<?php

namespace Preferred\Domain\Users\Providers;

use Preferred\Domain\Users\Database\Factories\AuthorizedDeviceFactory;
use Preferred\Domain\Users\Database\Factories\LoginHistoryFactory;
use Preferred\Domain\Users\Database\Factories\ProfileFactory;
use Preferred\Domain\Users\Database\Factories\UserFactory;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Policies\AuthorizedDevicePolicy;
use Preferred\Domain\Users\Policies\LoginHistoryPolicy;
use Preferred\Domain\Users\Policies\ProfilePolicy;
use Preferred\Domain\Users\Policies\UserPolicy;
use Preferred\Infrastructure\Abstracts\AbstractServiceProvider;

class DomainServiceProvider extends AbstractServiceProvider
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
        User::class             => UserPolicy::class,
        Profile::class          => ProfilePolicy::class,
        AuthorizedDevice::class => AuthorizedDevicePolicy::class,
        LoginHistory::class     => LoginHistoryPolicy::class,
    ];

    protected $factories = [
        UserFactory::class,
        AuthorizedDeviceFactory::class,
        LoginHistoryFactory::class,
        ProfileFactory::class,
    ];
}
