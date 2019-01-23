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
        $router->group([
            'namespace'  => $this->namespace,
            'middleware' => ['api'],
            'prefix'     => 'api',
        ], function (Router $router) {

            ###################
            # GUEST
            ###################

            $router->group(['middleware' => 'guest'], function () use ($router) {
                $router->post('email/verify/{token}', 'EmailVerificationController@verify')
                    ->middleware('throttle:3,1')
                    ->name('api.email.verify');

                $router->post('devices/authorize/{token}', 'AuthorizeDeviceController@verify')
                    ->middleware('throttle:3,1')
                    ->name('api.device.authorize');

                $router->post('login', 'LoginController@login')->name('api.auth.login');
                $router->post('register', 'RegisterController@register')->name('api.auth.register');
                $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
                    ->middleware('throttle:5,1')
                    ->name('api.reset.email-link');

                $router->post('password/reset', 'ResetPasswordController@reset')
                    ->middleware('throttle:5,1')
                    ->name('api.reset.password');
            });

            ###################
            # 2FA
            ###################

            $router->group([
                'middleware' => [
                    'auth:api',
                    '2fa'
                ]
            ], function () use ($router) {
                $router->post('disable2fa', 'TwoFactorAuthenticationController@disable2fa')->name('api.disable2fa');
                $router->post('verify2fa', 'TwoFactorAuthenticationController@verify2fa')->name('api.verify2fa');

                $router->get('profile', 'ProfileController@profile')->name('api.profile');
                $router->patch('profile', 'ProfileController@update')->name('api.profile.update');

                $router->patch('profile/password',
                    'ProfileController@updatePassword')->name('api.profile.password.update');

                $router->patch('profile/notifications/visualize-all', 'ProfileController@visualizeAllNotifications')
                    ->name('api.profile.notifications.visualize-all');

                $router->patch('profile/notifications/{id}/visualize', 'ProfileController@visualizeNotification')
                    ->name('api.profile.notifications.visualize');

                $router->delete('devices/{id}', 'AuthorizeDeviceController@destroy')
                    ->middleware('throttle:3,1')
                    ->name('api.device.destroy');
            });

            ###################
            # JUST AUTH
            ###################

            $router->group(['middleware' => 'auth:api'], function () use ($router) {
                $router->post('logout', 'LoginController@logout')->name('api.auth.logout');

                $router->post('generate2faSecret', 'TwoFactorAuthenticationController@generate2faSecret')
                    ->name('api.generate2faSecret');

                $router->post('enable2fa', 'TwoFactorAuthenticationController@enable2fa')->name('api.enable2fa');
            });

            $router->post('account/disable/{token}', 'DisableAccountController@disable')
                ->middleware('throttle:1,1')
                ->name('api.account.disable');

            $router->post('broadcasting/auth', 'LoginController@broadcastAuth')->name('api.broadcasting.auth');
        });
    }
}
