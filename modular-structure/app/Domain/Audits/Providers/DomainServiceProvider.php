<?php

namespace App\Domain\Audits\Providers;

use App\Domain\Audits\Entities\Audit;
use App\Domain\Audits\Policies\AuditPolicy;
use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected string $alias = 'audits';

    protected bool $hasMigrations = true;

    protected bool $hasPolicies = true;

    protected array $policies = [
        Audit::class => AuditPolicy::class,
    ];

    protected array $providers = [
        EventServiceProvider::class,
    ];
}
