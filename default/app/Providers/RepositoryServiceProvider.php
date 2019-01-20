<?php

namespace App\Providers;

use App\Contracts\ProfileRepository;
use App\Contracts\UserRepository;
use App\Models\Profile;
use App\Models\User;
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
            UserRepository::class,
            ProfileRepository::class,
        ];
    }
}
