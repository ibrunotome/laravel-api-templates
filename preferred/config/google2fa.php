<?php

return [
    /*
     * Auth container binding
     */
    'enabled'              => true,

    /*
     * Lifetime in minutes.
     * In case you need your users to be asked for a new one time passwords from time to time.
     *
     * 0 = eternal
     */
    'lifetime'             => 0,

    /*
     * Renew lifetime at every new request.
     */
    'keep_alive'           => true,

    /*
     * Auth container binding.
     */
    'auth'                 => 'auth',

    /*
     * Auth guard container binding.
     */
    'auth_guard'           => 'api',

    /*
     * 2FA verified cache var.
     */
    'cache_var'            => 'google2fa',

    /*
     * Cache container binding.
     */
    'cache'                => 'cache',

    /*
     * Cache lifetime in minutes.
     * In case user Bearer token expire, remove token from cache
     * If cache_lifetime sets to 0. You must clean cache by hand.
     *
     * Default 1 day
     */
    'cache_lifetime'       => 1440,

    /*
     * One Time Password request input name.
     */
    'otp_input'            => 'one_time_password',

    /*
     * One Time Password Window.
     */
    'window'               => 0.5,

    /*
     * Forbid user to reuse One Time Passwords.
     */
    'forbid_old_passwords' => false,

    /*
     * User's table column for google2fa secret.
     */
    'otp_secret_column'    => 'google2fa_secret',

    /*
     * One Time Password View.
     */
    'view'                 => 'google2fa.index',

    /*
     * One Time Password error message.
     */
    'error_messages'       => [
        'wrong_otp'                   => "The 'One Time Password' typed was wrong",
        'unknown_error'               => 'Unknown Error',
        'one_time_password_requested' => 'Please provide one time password'
    ],

    /*
     * Custom MessageBag fields for Json response.
     */
    'custom_json_fields'   => [
        'route' => '2fa'
    ],

    /*
     * Throw exceptions or just fire events?
     */
    'throw_exceptions'     => true,
];
