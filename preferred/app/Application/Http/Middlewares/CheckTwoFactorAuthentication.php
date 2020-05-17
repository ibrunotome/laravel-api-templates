<?php

namespace Preferred\Application\Http\Middlewares;

use Closure;
use Illuminate\Http\Response;
use Preferred\Infrastructure\Support\TwoFactorAuthenticator;
use Preferred\Interfaces\Http\Controllers\ResponseTrait;

class CheckTwoFactorAuthentication
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $twoFactorAuthentication = new TwoFactorAuthenticator($request);

        if ($twoFactorAuthentication->isAuthenticated()) {
            return $next($request);
        }

        $message = __('Invalid 2FA verification code. Please try again');

        return $this->respondWithCustomData([
            'message'     => $message,
            'isVerify2fa' => 1,
        ], Response::HTTP_LOCKED);
    }
}
