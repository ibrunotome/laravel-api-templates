<?php

namespace Preferred\Domain\Companies\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Preferred\Domain\Companies\Http\Controllers';

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
