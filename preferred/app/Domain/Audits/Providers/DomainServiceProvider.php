<?php

namespace Preferred\Domain\Audits\Providers;

use Preferred\Domain\Audits\Entities\Audit;
use Preferred\Domain\Audits\Policies\AuditPolicy;
use Preferred\Infrastructure\Abstracts\ServiceProvider;

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
