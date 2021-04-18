<?php

namespace App\Domain\Notifications\Providers;

use App\Domain\Notifications\Policies\NotificationPolicy;
use App\Infrastructure\Abstracts\ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;

class DomainServiceProvider extends ServiceProvider
{
    protected string $alias = 'notifications';

    protected bool $hasMigrations = true;

    protected bool $hasPolicies = true;

    protected array $policies = [
        DatabaseNotification::class => NotificationPolicy::class,
    ];
}
