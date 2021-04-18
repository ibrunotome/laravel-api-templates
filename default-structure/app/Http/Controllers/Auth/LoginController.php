<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\LockedException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Services\AuthorizedDeviceService;
use App\Services\LoginHistoryService;
use App\Support\TwoFactorAuthenticator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Agent\Agent;

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

    /**
     * {@inheritdoc}
     */
    protected function attemptLogin(Request $request)
    {
        $token = $this->guard()->attempt($this->credentials($request));

        if ($token) {
            $this->guard()->setToken($token);
            return true;
        }

        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = $request->user();

        try {
            $this->checkUserIfIsActive($user, $request);
            $this->checkIfUserHasVerifiedEmail($user, $request);
            $data = $this->getDeviceInfo($request);
            $data['user_id'] = $user->id;
            $this->checkIfIsDeviceIsAuthorized($user, $data);
        } catch (LockedException $exception) {
            return $this->respondWithCustomData([
                'message'     => $exception->getMessage(),
                'isVerify2fa' => false,
            ], Response::HTTP_LOCKED);
        }

        $this->createNewLoginHistory($user, $data);
        $this->clearLoginAttempts($request);

        $token = (string)$this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return $this->respondWithCustomData([
            'token'     => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => $expiration - time(),
        ]);
    }

    private function checkUserIfIsActive(User $user, Request $request)
    {
        if (!$user->is_active) {
            $this->logout($request);

            $supportLink = config('app.support_url');

            $message = __(
                'Your account has been disabled, to enable it again, ' .
                'please contact :support_link to start the process.',
                ['support_link' => '<a href="' . $supportLink . '">' . $supportLink . '</a>']
            );

            throw new LockedException($message);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $id = $this->guard()->id();

        (new TwoFactorAuthenticator($request))->logout();
        Cache::forget($id);
        Cache::tags('users:' . $id)->flush();

        $this->guard()->logout();
    }

    private function checkIfUserHasVerifiedEmail(User $user, Request $request)
    {
        if (!$user->hasVerifiedEmail()) {
            Notification::send($user, new VerifyEmailNotification($user->email_token_confirmation));

            $this->logout($request);

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

        $geoip = geoip($request->ip());

        return [
            'user_id'          => auth()->id(),
            'ip'               => $request->ip(),
            'device'           => $agent->device(),
            'platform'         => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'browser'          => $agent->browser(),
            'browser_version'  => $agent->version($agent->browser()),
            'city'             => $geoip->getAttribute('city'),
            'region_code'      => $geoip->getAttribute('state'),
            'region_name'      => $geoip->getAttribute('state_name'),
            'country_code'     => $geoip->getAttribute('iso_code'),
            'country_name'     => $geoip->getAttribute('country'),
            'continent_code'   => $geoip->getAttribute('continent'),
            'latitude'         => $geoip->getAttribute('lat'),
            'longitude'        => $geoip->getAttribute('lon'),
            'zipcode'          => $geoip->getAttribute('postal_code'),
        ];
    }

    private function checkIfIsDeviceIsAuthorized(User $user, array $data)
    {
        if (!config('app.will_check_device_is_authorized')) {
            return;
        }

        $authorizedDeviceService = app(AuthorizedDeviceService::class);

        $response = $authorizedDeviceService->store($user, $data);

        if (!empty($response['error'])) {
            throw new LockedException($response['message']);
        }
    }

    private function createNewLoginHistory(User $user, array $data)
    {
        $loginHistoryService = app(LoginHistoryService::class);
        $loginHistoryService->store($user, $data);
    }
}
