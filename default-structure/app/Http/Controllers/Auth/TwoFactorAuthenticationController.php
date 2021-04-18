<?php

namespace App\Http\Controllers\Auth;

use App\Events\TwoFactorAuthenticationWasDisabled;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisableTwoFactorAuthenticationRequest;
use App\Http\Requests\EnableTwoFactorAuthenticationRequest;
use App\Support\ExceptionFormat;
use App\Support\TwoFactorAuthenticator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Generate a new 2fa entry for current logged user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function generate2faSecret(Request $request)
    {
        $twoFactorAuthentication = new TwoFactorAuthenticator($request);

        $user = $request->user();

        $user->google2fa_enable = false;
        $user->google2fa_secret = $twoFactorAuthentication->generateSecretKey(32);
        $google2faUrl = $twoFactorAuthentication->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
        $user->google2fa_url = $google2faUrl;
        $user->save();

        return $this->respondWithCustomData([
            'message'         => __('Secret Key generated. Follow the next steps'),
            'google2faSecret' => $user->google2fa_secret,
            'google2faUrl'    => $google2faUrl,
        ]);
    }

    /**
     * Enable the previously generated 2fa.
     *
     * @param EnableTwoFactorAuthenticationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable2fa(EnableTwoFactorAuthenticationRequest $request)
    {
        $twoFactorAuthentication = new TwoFactorAuthenticator($request);
        $secret = $request->input('one_time_password');

        $user = $request->user();

        try {
            $valid = $twoFactorAuthentication->verifyKey($user->google2fa_secret, $secret);

            if ($valid) {
                $user->google2fa_enable = true;
                $user->save();

                $twoFactorAuthentication->login();

                return $this->respondWithCustomData([
                    'message'         => __('2FA is enabled successfully'),
                    'google2faEnable' => true,
                ]);
            }
        } catch (Exception $exception) {
            Log::error(ExceptionFormat::log($exception));
        }

        return $this->respondWithCustomData([
            'message'         => __('Invalid 2FA verification code. Please try again'),
            'isVerify2fa'     => false,
            'google2faEnable' => false,
        ], Response::HTTP_LOCKED);
    }

    /**
     * Disable the 2fa of current logged user.
     *
     * @param DisableTwoFactorAuthenticationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function disable2fa(DisableTwoFactorAuthenticationRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->get('password'), $user->password)) {
            return $this->respondWithCustomData(
                ['message' => __('Invalid password. Please try again')],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user->google2fa_enable = false;
        $user->google2fa_secret = null;
        $user->google2fa_url = null;
        $user->save();

        event(new TwoFactorAuthenticationWasDisabled($user));

        return $this->respondWithCustomData([
            'message'         => __('2FA is now disabled'),
            'google2faEnable' => false,
        ]);
    }

    /**
     * If request pass of middleware, the OTP was successfully verified.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify2fa(Request $request)
    {
        Cache::tags('users:' . auth()->id())->flush();

        return $this->respondWithCustomData(['message' => __('2FA successfully verified')]);
    }
}
