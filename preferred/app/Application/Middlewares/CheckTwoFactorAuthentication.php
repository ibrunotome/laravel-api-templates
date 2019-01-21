<?php

namespace Preferred\Application\Middlewares;

use Closure;
use Illuminate\Http\Response;
use Preferred\Infrastructure\Support\TwoFactorAuthentication;
use Preferred\Interfaces\Http\Controllers\ResponseTrait;

class CheckTwoFactorAuthentication
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
        $twoFactorAuthentication = new TwoFactorAuthentication($request);

        if ($twoFactorAuthentication->isAuthenticated()) {
            return $next($request);
        }

        $message = __('Invalid 2FA verification code. Please try again');

        return $this->respondWithCustomData([
            'message'      => $message,
            'is_verify2fa' => 1,
        ], Response::HTTP_LOCKED);
    }
}
