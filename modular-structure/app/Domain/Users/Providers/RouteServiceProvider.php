<?php

namespace Preferred\Domain\Users\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Preferred\Domain\Users\Http\Controllers';

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
                    ->post('email/verify/{token}', 'EmailVerificationController@verify')
                    ->middleware('throttle:3,1')
                    ->name('api.email.verify');

                $router
                    ->post('devices/authorize/{token}', 'AuthorizeDeviceController@authorizeDevice')
                    ->middleware('throttle:3,1')
                    ->name('api.device.authorize');

                $router
                    ->post('login', 'LoginController@login')
                    ->name('api.auth.login');

                $router
                    ->post('register', 'RegisterController@register')
                    ->name('api.auth.register');

                $router
                    ->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
                    ->middleware('throttle:5,1')
                    ->name('api.reset.email-link');

                $router
                    ->post('password/reset', 'ResetPasswordController@reset')
                    ->middleware('throttle:5,1')
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
                    ->post('disable2fa', 'TwoFactorAuthenticationController@disable2fa')
                    ->name('api.disable2fa');

                $router
                    ->post('verify2fa', 'TwoFactorAuthenticationController@verify2fa')
                    ->name('api.verify2fa');

                $router
                    ->get('me', 'UserController@profile')
                    ->name('api.me');

                $router
                    ->patch('me', 'UserController@updateMe')
                    ->name('api.me.update');

                $router
                    ->apiResource('users', 'UserController')
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
                    ->patch('password/update', 'UserController@updatePassword')
                    ->name('api.password.update');

                $router
                    ->patch('notifications/visualize-all', 'NotificationController@visualizeAllNotifications')
                    ->name('api.notifications.visualize-all');

                $router
                    ->patch('notifications/{id}/visualize', 'NotificationController@visualizeNotification')
                    ->name('api.notifications.visualize');

                $router
                    ->delete('devices/{id}', 'AuthorizeDeviceController@destroy')
                    ->middleware('throttle:3,1')
                    ->name('api.device.destroy');
            });
    }

    private function mapRoutesWhenBasicAuthIsRequired(Router $router): void
    {
        $router
            ->group(['middleware' => 'auth:api'], function () use ($router) {
                $router
                    ->post('logout', 'LoginController@logout')
                    ->name('api.auth.logout');

                $router
                    ->post('generate2faSecret', 'TwoFactorAuthenticationController@generate2faSecret')
                    ->name('api.generate2faSecret');

                $router
                    ->post('enable2fa', 'TwoFactorAuthenticationController@enable2fa')
                    ->name('api.enable2fa');
            });
    }

    private function mapRoutesWhenAuthenticationDoesntMatter(Router $router): void
    {
        $router
            ->post('account/disable/{token}', 'DisableAccountController@disable')
            ->middleware('throttle:1,1')
            ->name('api.account.disable');

        $router
            ->get('ping', 'UtilController@serverTime')
            ->name('api.server.ping');

        $router
            ->post('ws/auth', 'LoginController@wsAuth')
            ->name('api.ws.auth');
    }
}
