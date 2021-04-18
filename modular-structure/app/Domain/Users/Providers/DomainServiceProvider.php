<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\Permission;
use App\Domain\Users\Entities\Role;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Policies\AuthorizedDevicePolicy;
use App\Domain\Users\Policies\LoginHistoryPolicy;
use App\Domain\Users\Policies\PermissionPolicy;
use App\Domain\Users\Policies\RolePolicy;
use App\Domain\Users\Policies\UserPolicy;
use App\Infrastructure\Abstracts\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    protected string $alias = 'users';

    protected bool $hasMigrations = true;

    protected bool $hasTranslations = true;

    protected bool $hasPolicies = true;

    protected array $providers = [
        RouteServiceProvider::class,
        RepositoryServiceProvider::class,
        EventServiceProvider::class,
        //        BroadcastServiceProvider::class,
    ];

    protected array $policies = [
        AuthorizedDevice::class => AuthorizedDevicePolicy::class,
        LoginHistory::class     => LoginHistoryPolicy::class,
        Permission::class       => PermissionPolicy::class,
        Role::class             => RolePolicy::class,
        User::class             => UserPolicy::class,
    ];
}
