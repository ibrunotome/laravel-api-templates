<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Http\Controllers\AuthorizeDeviceController;
use App\Domain\Users\Http\Controllers\DisableAccountController;
use App\Domain\Users\Http\Controllers\EmailVerificationController;
use App\Domain\Users\Http\Controllers\ForgotPasswordController;
use App\Domain\Users\Http\Controllers\LoginController;
use App\Domain\Users\Http\Controllers\NotificationController;
use App\Domain\Users\Http\Controllers\RegisterController;
use App\Domain\Users\Http\Controllers\ResetPasswordController;
use App\Domain\Users\Http\Controllers\TwoFactorAuthenticationController;
use App\Domain\Users\Http\Controllers\UserController;
use App\Domain\Users\Http\Controllers\UtilController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();
    }

    public function map(Router $router): void
    {
        if (config('register.api_routes')) {
            $this->mapApiRoutes($router);
        }
    }

    protected function mapApiRoutes(Router $router): void
    {
        $router
            ->group([
                'namespace'  => $this->namespace,
                'prefix'     => 'api',
                'middleware' => ['api'],
            ], function (Router $router) {
                $this->mapRoutesWhenGuest($router);
                $this->mapRoutesWhen2faIsAvailable($router);
                $this->mapRoutesWhenBasicAuthIsRequired($router);
                $this->mapRoutesWhenAuthenticationDoesntMatter($router);
            });
    }

    private function mapRoutesWhenGuest(Router $router): void
    {
        $router
            ->group(['middleware' => 'guest'], function () use ($router) {
                $router
                    ->post('email/verify/{token}', [EmailVerificationController::class, 'verify'])
                    ->middleware('throttle:hard')
                    ->name('api.email.verify');

                $router
                    ->post('devices/authorize/{token}', [AuthorizeDeviceController::class, 'authorizeDevice'])
                    ->middleware('throttle:hard')
                    ->name('api.device.authorize');

                $router
                    ->post('login', [LoginController::class, 'login'])
                    ->name('api.auth.login');

                $router
                    ->post('register', [RegisterController::class, 'register'])
                    ->name('api.auth.register');

                $router
                    ->post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
                    ->middleware('throttle:hard')
                    ->name('api.reset.email-link');

                $router
                    ->post('password/reset', [ResetPasswordController::class, 'reset'])
                    ->middleware('throttle:hard')
                    ->name('api.reset.password');
            });
    }

    private function mapRoutesWhen2faIsAvailable(Router $router): void
    {
        $router
            ->group([
                'middleware' => [
                    'auth:api',
                    '2fa',
                ],
            ], function () use ($router) {
                $router
                    ->post('disable2fa', [TwoFactorAuthenticationController::class, 'disable2fa'])
                    ->name('api.disable2fa');

                $router
                    ->post('verify2fa', [TwoFactorAuthenticationController::class, 'verify2fa'])
                    ->name('api.verify2fa');

                $router
                    ->get('me', [UserController::class, 'profile'])
                    ->name('api.me');

                $router
                    ->patch('me', [UserController::class, 'updateMe'])
                    ->name('api.me.update');

                $router
                    ->apiResource('users', UserController::class)
                    ->only([
                        'index',
                        'show',
                        'store',
                        'update',
                    ])
                    ->names([
                        'index'  => 'api.users.index',
                        'show'   => 'api.users.show',
                        'store'  => 'api.users.store',
                        'update' => 'api.users.update',
                    ]);

                $router
                    ->patch('password/update', [UserController::class, 'updatePassword'])
                    ->name('api.password.update');

                $router
                    ->patch('notifications/visualize-all', [NotificationController::class, 'visualizeAllNotifications'])
                    ->name('api.notifications.visualize-all');

                $router
                    ->patch('notifications/{id}/visualize', [NotificationController::class, 'visualizeNotification'])
                    ->name('api.notifications.visualize');

                $router
                    ->delete('devices/{id}', [AuthorizeDeviceController::class, 'destroy'])
                    ->middleware('throttle:hard')
                    ->name('api.device.destroy');
            });
    }

    private function mapRoutesWhenBasicAuthIsRequired(Router $router): void
    {
        $router
            ->group(['middleware' => 'auth:api'], function () use ($router) {
                $router
                    ->post('logout', [LoginController::class, 'logout'])
                    ->name('api.auth.logout');

                $router
                    ->post('generate2faSecret', [TwoFactorAuthenticationController::class, 'generate2faSecret'])
                    ->name('api.generate2faSecret');

                $router
                    ->post('enable2fa', [TwoFactorAuthenticationController::class, 'enable2fa'])
                    ->name('api.enable2fa');
            });
    }

    private function mapRoutesWhenAuthenticationDoesntMatter(Router $router): void
    {
        $router
            ->post('account/disable/{token}', [DisableAccountController::class, 'disable'])
            ->middleware('throttle:hard')
            ->name('api.account.disable');

        $router
            ->get('ping', [UtilController::class, 'serverTime'])
            ->name('api.server.ping');
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        RateLimiter::for('hard', function (Request $request) {
            return Limit::perMinute(2)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
