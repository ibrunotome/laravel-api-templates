<?php

namespace Preferred\Domain\Companies\Providers;

use Preferred\Domain\Companies\Database\Factories\CompanyFactory;
use Preferred\Domain\Companies\Entities\Company;
use Preferred\Domain\Companies\Policies\CompanyPolicy;
use Preferred\Infrastructure\Abstracts\AbstractServiceProvider;

class DomainServiceProvider extends AbstractServiceProvider
{
    protected $alias = 'companies';

    protected $hasMigrations = true;

    protected $hasTranslations = true;

    protected $hasFactories = true;

    protected $hasPolicies = true;

    protected $providers = [
        RouteServiceProvider::class,
        RepositoryServiceProvider::class,
        EventServiceProvider::class,
    ];

    protected $policies = [
        Company::class => CompanyPolicy::class,
    ];

    protected $factories = [
        CompanyFactory::class,
    ];
}
