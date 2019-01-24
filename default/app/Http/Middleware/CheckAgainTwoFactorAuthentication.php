<?php

namespace App\Http\Middleware;

use App\Http\ResponseTrait;
use App\Models\User;
use App\Support\TwoFactorAuthentication;
use Closure;
use Illuminate\Http\Response;

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
        $user = User::with(['profile'])->find(auth()->id());

        if (!empty($user->profile->google2fa_enable)) {
            $twoFactorAuthentication = new TwoFactorAuthentication($request);

            if (!empty($request->one_time_password) && $twoFactorAuthentication->verifyGoogle2FA
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
