<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Config Geetest Id
    |--------------------------------------------------------------------------
    |
    | Here you can config your geetest id.
    |
    */
    'id'         => env('GEETEST_ID'),

    /*
    |--------------------------------------------------------------------------
    | Config Geetest Key
    |--------------------------------------------------------------------------
    |
    | Here you can config your geetest key.
    |
    */
    'key'        => env('GEETEST_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Config Geetest Cache Key
    |--------------------------------------------------------------------------
    |
    | Here you can config your cache key
    |
    */
    'cache_key'  => 'GEETEST_KEY_%s',

    /*
    |--------------------------------------------------------------------------
    | Config Geetest URL
    |--------------------------------------------------------------------------
    |
    | Here you can config your geetest url for ajax validation.
    |
    */
    'url'        => 'api/geetest',

    /*
    |--------------------------------------------------------------------------
    | Config Geetest Protocol
    |--------------------------------------------------------------------------
    |
    | Here you can config your geetest url for ajax validation.
    |
    | Options: http or https
    |
    */
    'protocol'   => 'https',

    /*
    |--------------------------------------------------------------------------
    | Config Geetest middleware
    |--------------------------------------------------------------------------
    |
    | Here you can config your geetest middleware for ajax validation.
    |
    */
    'middleware' => 'api'

];
