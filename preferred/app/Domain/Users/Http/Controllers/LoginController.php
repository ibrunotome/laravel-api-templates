<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Agent\Agent;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Exceptions\LockedException;
use Preferred\Domain\Users\Notifications\VerifyEmailNotification;
use Preferred\Domain\Users\Services\AuthorizedDeviceService;
use Preferred\Domain\Users\Services\LoginHistoryService;
use Preferred\Infrastructure\Support\TwoFactorAuthenticator;
use Preferred\Interfaces\Http\Controllers\Controller;
use Sujip\Ipstack\Ipstack;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function broadcastAuth(Request $request)
    {
        $userId = str_replace('private-users.', '', $request->get('channel_name'));

        $user = Cache::remember($userId, 60, function () use ($userId) {
            return User::with([])->find($userId);
        });

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        Broadcast::auth($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function logout(Request $request)
    {
        $id = $this->guard()->id();

        (new TwoFactorAuthenticator($request))->logout();
        Cache::forget($id);
        Cache::tags('users:' . $id);

        $this->guard()->logout();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $token = $this->guard()->setTTL(config('jwt.ttl'))->attempt($this->credentials($request));

        if ($token) {
            $this->guard()->setToken($token);

            return true;
        }

        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            $this->checkIfIsActive($user, $request);
            $this->checkIfHasVerifiedEmail($user);
            $data = $this->getDeviceInfo($request);
            $data['user_id'] = $user->id;
            $this->checkIfIsDeviceIsAuthorized($user, $data);
        } catch (LockedException $exception) {
            return $this->respondWithCustomData([
                'message'     => $exception->getMessage(),
                'isVerify2fa' => 0,
            ], Response::HTTP_LOCKED);
        }

        $this->createNewLoginHistory($user, $data);
        $this->clearLoginAttempts($request);

        $token = (string)$this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return $this->respondWithCustomData([
            'token'      => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration - time(),
        ]);
    }

    private function checkIfIsActive(User $user, Request $request)
    {
        if (!$user->is_active) {
            (new TwoFactorAuthenticator($request))->logout();
            Cache::forget($user->id);
            Cache::tags('users:' . $user->id)->flush();
            auth()->logout();

            $message = __(
                'Your account has been disabled, to enable it again, please contact :support_link to start the process.',
                ['support_link' => '<a href="' . config('app.support_url') . '">' . config('app.support_url') . '</a>']
            );

            throw new LockedException($message);
        }
    }

    private function checkIfHasVerifiedEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            /** @var Profile $profile */
            $profile = app(ProfileRepository::class)->with(['user'])->findOneBy(['user_id' => $user->id]);

            Notification::send($user, new VerifyEmailNotification($profile->email_token_confirmation));

            Cache::forget($user->id);
            Cache::tags('users:' . $user->id)->flush();
            auth()->logout();

            $message = __(
                'We sent a confirmation email to :email. Please follow the instructions to complete your registration.',
                ['email' => $user->email]
            );

            throw new LockedException($message);
        }
    }

    private function getDeviceInfo(Request $request)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());
        $agent->setHttpHeaders($request->headers);

        $ipstack = new Ipstack($request->ip());

        return [
            'user_id'          => auth()->id(),
            'ip'               => $request->ip(),
            'device'           => $agent->device(),
            'platform'         => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'browser'          => $agent->browser(),
            'browser_version'  => $agent->version($agent->browser()),
            'city'             => $ipstack->city(),
            'region_code'      => $ipstack->regionCode(),
            'region_name'      => $ipstack->region(),
            'country_code'     => $ipstack->countryCode(),
            'country_name'     => $ipstack->country(),
            'continent_code'   => $ipstack->continentCode(),
            'continent_name'   => $ipstack->continent(),
            'latitude'         => $ipstack->latitude(),
            'longitude'        => $ipstack->longitude(),
            'zipcode'          => $ipstack->zip(),
        ];
    }

    private function checkIfIsDeviceIsAuthorized(User $user, array $data)
    {
        /** @var AuthorizedDeviceService $authorizedDeviceService */
        $authorizedDeviceService = app(AuthorizedDeviceService::class);

        $response = $authorizedDeviceService->store($user, $data);

        if (!empty($response['error'])) {
            throw new LockedException($response['message']);
        }
    }

    private function createNewLoginHistory(User $user, array $data)
    {
        /** @var LoginHistoryService $loginHistoryService */
        $loginHistoryService = app(LoginHistoryService::class);
        $loginHistoryService->store($user, $data);
    }
}
