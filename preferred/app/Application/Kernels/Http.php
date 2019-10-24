<?php

namespace Preferred\Application\Kernels;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Http extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Preferred\Application\Middlewares\ForceAcceptJson::class,
        \Preferred\Application\Middlewares\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Preferred\Application\Middlewares\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Preferred\Application\Middlewares\TrustProxies::class,
        \Preferred\Application\Middlewares\SetLocale::class,
        \Illuminate\Http\Middleware\SetCacheHeaders::class,
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
        'auth'       => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'   => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'can'        => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'      => \Preferred\Application\Middlewares\RedirectIfAuthenticated::class,
        '2fa'        => \Preferred\Application\Middlewares\CheckTwoFactorAuthentication::class,
    ];


    /**
     * The priority-sorted list of middleware.
     * This forces the listed middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Preferred\Application\Middlewares\ForceAcceptJson::class,
        \Preferred\Application\Middlewares\CheckForMaintenanceMode::class,
        \Illuminate\Auth\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Preferred\Application\Middlewares\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Preferred\Application\Middlewares\TrustProxies::class,
        \Preferred\Application\Middlewares\SetLocale::class,
        \Illuminate\Http\Middleware\SetCacheHeaders::class,
    ];
}
