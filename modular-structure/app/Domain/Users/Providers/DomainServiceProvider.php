<?php

namespace Preferred\Domain\Users\Providers;

use Preferred\Domain\Users\Database\Factories\AuthorizedDeviceFactory;
use Preferred\Domain\Users\Database\Factories\LoginHistoryFactory;
use Preferred\Domain\Users\Database\Factories\UserFactory;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Permission;
use Preferred\Domain\Users\Entities\Role;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Policies\AuthorizedDevicePolicy;
use Preferred\Domain\Users\Policies\LoginHistoryPolicy;
use Preferred\Domain\Users\Policies\PermissionPolicy;
use Preferred\Domain\Users\Policies\RolePolicy;
use Preferred\Domain\Users\Policies\UserPolicy;
use Preferred\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected $alias = 'users';

    protected $hasMigrations = true;

    protected $hasTranslations = true;

    protected $hasFactories = true;

    protected $hasPolicies = true;

    protected $providers = [
        RouteServiceProvider::class,
        RepositoryServiceProvider::class,
        EventServiceProvider::class,
        BroadcastServiceProvider::class,
    ];

    protected $policies = [
        AuthorizedDevice::class => AuthorizedDevicePolicy::class,
        LoginHistory::class     => LoginHistoryPolicy::class,
        Permission::class       => PermissionPolicy::class,
        Role::class             => RolePolicy::class,
        User::class             => UserPolicy::class,
    ];

    protected $factories = [
        AuthorizedDeviceFactory::class,
        LoginHistoryFactory::class,
        UserFactory::class,
    ];
}
