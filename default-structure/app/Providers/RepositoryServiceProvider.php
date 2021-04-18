<?php

namespace App\Providers;

use App\Contracts\AuthorizedDeviceRepository;
use App\Contracts\LoginHistoryRepository;
use App\Contracts\UserRepository;
use App\Models\AuthorizedDevice;
use App\Models\LoginHistory;
use App\Models\User;
use App\Repositories\EloquentAuthorizedDevicesRepository;
use App\Repositories\EloquentLoginHistoryRepository;
use App\Repositories\EloquentUserRepository;
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
