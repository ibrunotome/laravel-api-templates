<?php

namespace App\Domain\Users\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::channel('users.{id}', function ($user, $id) {
            return $user->id === $id;
        });
    }
}
