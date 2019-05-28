<?php

namespace Preferred\Application\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(\Illuminate\Session\SessionServiceProvider::class);
        }
    }
}
