<?php

namespace App\Infrastructure\Abstracts;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use ReflectionClass;

abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var string Alias for load tranlations and views
     */
    protected string $alias;

    /**
     * @var bool Set if will load commands
     */
    protected bool $hasCommands = false;

    /**
     * @var bool Set if will load migrations
     */
    protected bool $hasMigrations = false;

    /**
     * @var bool Set if will load translations
     */
    protected bool $hasTranslations = false;

    /**
     * @var bool Set if will load policies
     */
    protected bool $hasPolicies = false;

    /**
     * @var array List of custom Artisan commands
     */
    protected array $commands = [];

    /**
     * @var array List of providers to load
     */
    protected array $providers = [];

    /**
     * @var array List of policies to load
     */
    protected array $policies = [];

    /**
     * Boot required registering of views and translations.
     *
     * @throws \ReflectionException
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerTranslations();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        if ($this->hasPolicies && config('register.policies')) {
            foreach ($this->policies as $key => $value) {
                Gate::policy($key, $value);
            }
        }
    }

    /**
     * Register domain custom Artisan commands.
     */
    protected function registerCommands()
    {
        if ($this->hasCommands && config('register.commands')) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register domain migrations.
     *
     * @throws \ReflectionException
     */
    protected function registerMigrations()
    {
        if ($this->hasMigrations && config('register.migrations')) {
            $this->loadMigrationsFrom($this->domainPath('Database/Migrations'));
        }
    }

    /**
     * Detects the domain base path so resources can be proper loaded on child classes.
     *
     * @param string $append
     * @return string
     * @throws \ReflectionException
     */
    protected function domainPath($append = null): string
    {
        $reflection = new ReflectionClass($this);

        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }

    /**
     * Register domain translations.
     *
     * @throws \ReflectionException
     */
    protected function registerTranslations()
    {
        if ($this->hasTranslations && config('register.translations')) {
            $this->loadJsonTranslationsFrom($this->domainPath('Resources/Lang'));
        }
    }

    /**
     * Register Domain ServiceProviders.
     */
    public function register()
    {
        collect($this->providers)->each(function ($providerClass) {
            $this->app->register($providerClass);
        });
    }
}
