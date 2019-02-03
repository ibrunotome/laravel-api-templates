<?php

namespace Preferred\Domain\Companies\Providers;

use Illuminate\Support\ServiceProvider;
use Preferred\Domain\Companies\Contracts\CompanyRepository;
use Preferred\Domain\Companies\Entities\Company;
use Preferred\Domain\Companies\Repositories\EloquentCompanyRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CompanyRepository::class, function () {
            return new EloquentCompanyRepository(new Company());
        });

        //:end-bindings:
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            CompanyRepository::class,
        ];
    }
}
