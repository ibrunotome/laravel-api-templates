<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

###################
# GUEST
###################

Route::group(['middleware' => 'guest'], function () {
    Route::post('email/verify/{token}', 'Auth\EmailVerificationController@verify')
        ->middleware('throttle:3,1')
        ->name('api.email.verify');

    Route::post('devices/authorize/{token}', 'Auth\AuthorizeDeviceController@verify')
        ->middleware('throttle:3,1')
        ->name('api.device.authorize');

    Route::post('login', 'Auth\LoginController@login')
        ->name('api.auth.login');

    Route::post('register', 'Auth\RegisterController@register')
        ->name('api.auth.register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
        ->middleware('throttle:5,1')
        ->name('api.reset.email-link');

    Route::post('password/reset', 'Auth\ResetPasswordController@reset')
        ->middleware('throttle:5,1')
        ->name('api.reset.password');
});

###################
# JUST AUTH
###################

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout')
        ->name('api.auth.logout');

    Route::post('generate2faSecret', 'Auth\TwoFactorAuthenticationController@generate2faSecret')
        ->name('api.generate2faSecret');

    Route::post('enable2fa', 'Auth\TwoFactorAuthenticationController@enable2fa')
        ->name('api.enable2fa');
});

###################
# 2FA
###################

Route::group([
    'middleware' => [
        'auth:api',
        '2fa',
    ]
], function () {
    Route::post('disable2fa', 'Auth\TwoFactorAuthenticationController@disable2fa')
        ->name('api.disable2fa');

    Route::post('verify2fa', 'Auth\TwoFactorAuthenticationController@verify2fa')
        ->name('api.verify2fa');

    Route::get('me/profile', 'ProfileController@me')
        ->name('api.profiles.me');

    Route::patch('me/profile', 'ProfileController@updateMe')
        ->name('api.profiles.me.update');

    Route::apiResource('profiles', 'ProfileController')
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

    Route::get('me', 'UserController@me')
        ->name('api.me');

    Route::patch('me', 'UserController@updateMe')
        ->name('api.me.update');

    Route::apiResource('users', 'UserController')
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

    Route::apiResource('companies', 'CompanyController')
        ->only([
            'index',
            'show',
            'store',
            'update',
        ])
        ->names([
            'index'  => 'api.companies.index',
            'show'   => 'api.companies.show',
            'store'  => 'api.companies.store',
            'update' => 'api.companies.update',
        ]);

    Route::patch('password/update', 'UserController@updatePassword')
        ->name('api.password.update');

    Route::patch('notifications/visualize-all', 'NotificationController@visualizeAll')
        ->name('api.notifications.visualize-all');

    Route::patch('notifications/{id}/visualize', 'NotificationController@visualize')
        ->name('api.notifications.visualize');

    Route::delete('devices/{id}', 'Auth\AuthorizeDeviceController@destroy')
        ->middleware('throttle:3,1')
        ->name('api.device.destroy');
});

Route::post('broadcasting/auth', 'Auth\LoginController@broadcastAuth')->name('api.broadcasting.auth');

Route::post('/account/disable/{token}', 'Auth\DisableAccountController@disable')
    ->middleware('throttle:2,1')
    ->name('api.account.disable');