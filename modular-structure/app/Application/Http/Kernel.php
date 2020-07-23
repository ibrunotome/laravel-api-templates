<?php

namespace App\Application\Http;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Application\Http\Middlewares\CheckForMaintenanceMode;
use App\Application\Http\Middlewares\CheckTwoFactorAuthentication;
use App\Application\Http\Middlewares\ForceAcceptJson;
use App\Application\Http\Middlewares\RedirectIfAuthenticated;
use App\Application\Http\Middlewares\SetLocale;
use App\Application\Http\Middlewares\TrimStrings;
use App\Application\Http\Middlewares\TrustProxies;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        ForceAcceptJson::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        TrustProxies::class,
        SetLocale::class,
        SetCacheHeaders::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings'   => SubstituteBindings::class,
        'throttle'   => ThrottleRequests::class,
        'can'        => Authorize::class,
        'guest'      => RedirectIfAuthenticated::class,
        '2fa'        => CheckTwoFactorAuthentication::class,
    ];


    /**
     * The priority-sorted list of middleware.
     * This forces the listed middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        ForceAcceptJson::class,
        CheckForMaintenanceMode::class,
        Authenticate::class,
        SubstituteBindings::class,
        Authorize::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        TrustProxies::class,
        SetLocale::class,
        SetCacheHeaders::class,
    ];
}
