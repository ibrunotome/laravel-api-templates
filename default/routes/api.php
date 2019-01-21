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

########
# AUTH
########

Route::group(['middleware' => 'guest'], function () {
    Route::post('login', 'Auth\LoginController@login')->name('api.auth.login');
    Route::post('register', 'Auth\RegisterController@register')->name('api.auth.register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
        ->middleware('throttle:3,1')
        ->name('api.reset.email-link');

    Route::post('password/reset', 'Auth\ResetPasswordController@reset')
        ->middleware('throttle:3,1')
        ->name('api.reset.password');

    Route::post('email/verify/{token}', 'Auth\EmailVerificationController@verify')
        ->middleware('throttle:3,1')
        ->name('api.email.verify');
});

Route::post('broadcasting/auth', 'Auth\LoginController@broadcastAuth')->name('api.broadcasting.auth');

Route::post('/account/disable/{token}', 'Auth\DisableAccountController@disable')
    ->middleware('throttle:2,1')
    ->name('api.account.disable');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('api.auth.logout');

    Route::post('generate2faSecret', 'Auth\TwoFactorAuthenticationController@generate2faSecret')
        ->name('api.generate2faSecret');

    Route::post('enable2fa', 'Auth\TwoFactorAuthenticationController@enable2fa')->name('api.enable2fa');
});

Route::group([
    'middleware' => [
        'auth:api',
        '2fa',
    ]
], function () {
    Route::post('disable2fa', 'Auth\TwoFactorAuthenticationController@disable2fa')->name('api.disable2fa');
    Route::post('verify2fa', 'Auth\TwoFactorAuthenticationController@verify2fa')->name('api.verify2fa');

    Route::get('profile', 'ProfileController@profile')->name('api.profile');
    Route::patch('profile', 'ProfileController@update')->name('api.profile.update');
    Route::patch('profile/password', 'ProfileController@updatePassword')->name('api.profile.password.update');
});