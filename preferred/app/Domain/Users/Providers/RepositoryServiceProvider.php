<?php

namespace Preferred\Domain\Users\Providers;

use Illuminate\Support\ServiceProvider;
use Preferred\Domain\Users\Contracts\AuthorizedDeviceRepository;
use Preferred\Domain\Users\Contracts\LoginHistoryRepository;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Contracts\UserRepository;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Repositories\EloquentAuthorizedDevicesRepository;
use Preferred\Domain\Users\Repositories\EloquentLoginHistoryRepository;
use Preferred\Domain\Users\Repositories\EloquentProfileRepository;
use Preferred\Domain\Users\Repositories\EloquentUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthorizedDeviceRepository::class, function () {
            return new EloquentAuthorizedDevicesRepository(new AuthorizedDevice());
        });

        $this->app->singleton(LoginHistoryRepository::class, function () {
            return new EloquentLoginHistoryRepository(new LoginHistory());
        });

        $this->app->singleton(UserRepository::class, function () {
            return new EloquentUserRepository(new User());
        });

        $this->app->singleton(ProfileRepository::class, function () {
            return new EloquentProfileRepository(new Profile());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            AuthorizedDeviceRepository::class,
            LoginHistoryRepository::class,
            UserRepository::class,
            ProfileRepository::class,
        ];
    }
}
