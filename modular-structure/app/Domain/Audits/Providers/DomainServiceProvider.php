<?php

namespace App\Domain\Audits\Providers;

use App\Domain\Audits\Entities\Audit;
use App\Domain\Audits\Policies\AuditPolicy;
use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'audits';

    protected $hasMigrations = true;

    protected $hasPolicies = true;

    protected $policies = [
        Audit::class => AuditPolicy::class,
    ];

    protected $providers = [
        EventServiceProvider::class,
    ];
}
