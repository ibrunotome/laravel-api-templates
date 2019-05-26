<?php

namespace Preferred\Domain\Companies\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Preferred\Domain\Companies\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
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
     * @return void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router
            ->group([
                'namespace'  => $this->namespace,
                'prefix'     => 'api',
                'middleware' => [
                    'api',
                    'auth:api',
                    '2fa',
                ],
            ], function (Router $router) {
                $router
                    ->apiResource('companies', 'CompanyController')
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
            });
    }
}
