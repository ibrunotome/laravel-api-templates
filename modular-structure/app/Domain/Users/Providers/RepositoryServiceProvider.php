<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Contracts\AuthorizedDeviceRepository;
use App\Domain\Users\Contracts\LoginHistoryRepository;
use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Repositories\EloquentAuthorizedDevicesRepository;
use App\Domain\Users\Repositories\EloquentLoginHistoryRepository;
use App\Domain\Users\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

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
        ];
    }
}
