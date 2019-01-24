<?php

namespace Preferred\Application\Middlewares;

use Closure;
use Illuminate\Http\Response;
use Preferred\Domain\Users\Entities\User;
use Preferred\Infrastructure\Support\TwoFactorAuthenticator;
use Preferred\Interfaces\Http\Controllers\ResponseTrait;

class CheckAgainTwoFactorAuthentication
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $user = User::with(['profile:google2a_enable,google2fa_secret'])->find(auth()->id());

        if (!empty($user->profile->google2fa_enable)) {
            $twoFactorAuthenticator = new TwoFactorAuthenticator($request);

            if (!empty($request->one_time_password) && $twoFactorAuthenticator->verifyGoogle2FA
                ($user->profile->google2fa_secret, $request->one_time_password) === true) {
                return $next($request);
            }

            $message = __('Invalid 2FA verification code. Please try again');

            return $this->respondWithCustomData([
                'message'      => $message,
                'isVerify2fa'  => 0,
                'isRefresh2fa' => 1,
            ], Response::HTTP_LOCKED);
        }

        return $next($request);
    }
}
