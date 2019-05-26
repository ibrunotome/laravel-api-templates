<?php

namespace Preferred\Domain\Audits\Providers;

use Preferred\Domain\Audits\Entities\Audit;
use Preferred\Domain\Audits\Policies\AuditPolicy;
use Preferred\Infrastructure\Abstracts\AbstractServiceProvider;

class DomainServiceProvider extends AbstractServiceProvider
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
