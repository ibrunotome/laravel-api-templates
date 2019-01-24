<?php

namespace Preferred\Domain\Users\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Preferred\Domain\Users\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        if (config('register.api_routes')) {
            $this->mapApiRoutes($router);
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function mapApiRoutes(Router $router)
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

    private function mapRoutesWhenGuest(Router $router)
    {
        $router
            ->group(['middleware' => 'guest'], function () use ($router) {
                $router
                    ->post('email/verify/{token}', 'EmailVerificationController@verify')
                    ->middleware('throttle:3,1')
                    ->name('api.email.verify');

                $router
                    ->post('devices/authorize/{token}', 'AuthorizeDeviceController@verify')
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

    private function mapRoutesWhen2faIsAvailable(Router $router)
    {
        $router
            ->group([
                'middleware' => [
                    'auth:api',
                    '2fa'
                ]
            ], function () use ($router) {
                $router
                    ->post('disable2fa', 'TwoFactorAuthenticationController@disable2fa')
                    ->name('api.disable2fa');

                $router
                    ->post('verify2fa', 'TwoFactorAuthenticationController@verify2fa')
                    ->name('api.verify2fa');

                $router
                    ->get('me/profile', 'ProfileController@me')
                    ->name('api.profiles.me');

                $router
                    ->patch('me/profile', 'ProfileController@updateMe')
                    ->name('api.profiles.me.update');

                $router
                    ->apiResource('profiles', 'ProfileController')
                    ->only([
                        'index',
                        'show',
                        'update',
                    ])
                    ->names([
                        'index'  => 'api.profiles.index',
                        'show'   => 'api.profiles.show',
                        'update' => 'api.profiles.update',
                    ]);

                $router
                    ->get('me', 'UserController@me')
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
                    ->patch('notifications/visualize-all', 'NotificationController@visualizeAll')
                    ->name('api.notifications.visualize-all');

                $router
                    ->patch('notifications/{id}/visualize', 'NotificationController@visualize')
                    ->name('api.notifications.visualize');

                $router
                    ->delete('devices/{id}', 'AuthorizeDeviceController@destroy')
                    ->middleware('throttle:3,1')
                    ->name('api.device.destroy');
            });
    }

    private function mapRoutesWhenBasicAuthIsRequired(Router $router)
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

    private function mapRoutesWhenAuthenticationDoesntMatter(Router $router)
    {
        $router
            ->post('account/disable/{token}', 'DisableAccountController@disable')
            ->middleware('throttle:1,1')
            ->name('api.account.disable');

        $router
            ->post('broadcasting/auth', 'LoginController@broadcastAuth')
            ->name('api.broadcasting.auth');
    }
}
