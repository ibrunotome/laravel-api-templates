<?php

namespace App\Providers;

use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(SessionServiceProvider::class);
        }
    }
}
