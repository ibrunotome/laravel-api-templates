<?php

namespace Preferred\Domain\Notifications\Providers;

use Illuminate\Notifications\DatabaseNotification;
use Preferred\Domain\Notifications\Policies\NotificationPolicy;
use Preferred\Infrastructure\Abstracts\AbstractServiceProvider;

class DomainServiceProvider extends AbstractServiceProvider
{
    protected $alias = 'notifications';

    protected $hasMigrations = true;

    protected $hasPolicies = true;

    protected $policies = [
        DatabaseNotification::class => NotificationPolicy::class
    ];
}
