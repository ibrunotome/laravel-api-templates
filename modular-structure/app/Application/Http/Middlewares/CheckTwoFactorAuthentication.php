<?php

namespace App\Application\Http\Middlewares;

use App\Infrastructure\Support\TwoFactorAuthenticator;
use App\Interfaces\Http\Controllers\ResponseTrait;
use Closure;
use Illuminate\Http\Response;

class CheckTwoFactorAuthentication
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
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
