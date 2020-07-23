<?php

namespace App\Domain\Notifications\Providers;

use Illuminate\Notifications\DatabaseNotification;
use App\Domain\Notifications\Policies\NotificationPolicy;
use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'notifications';

    protected $hasMigrations = true;

    protected $hasPolicies = true;

    protected $policies = [
        DatabaseNotification::class => NotificationPolicy::class,
    ];
}
