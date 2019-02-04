<?php

namespace App\Providers;

use App\Contracts\AuthorizedDeviceRepository;
use App\Contracts\CompanyRepository;
use App\Contracts\LoginHistoryRepository;
use App\Contracts\ProfileRepository;
use App\Contracts\UserRepository;
use App\Models\AuthorizedDevice;
use App\Models\Company;
use App\Models\LoginHistory;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\EloquentAuthorizedDevicesRepository;
use App\Repositories\EloquentCompanyRepository;
use App\Repositories\EloquentLoginHistoryRepository;
use App\Repositories\EloquentProfileRepository;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

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

        $this->app->singleton(CompanyRepository::class, function () {
            return new EloquentCompanyRepository(new Company());
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

        //:end-bindings:
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
            CompanyRepository::class,
            LoginHistoryRepository::class,
            UserRepository::class,
            ProfileRepository::class,
        ];
    }
}
