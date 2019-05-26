<?php

namespace Preferred\Application\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Horizon::routeSlackNotificationsTo(config('services.SLACK_WEBHOOK_URL'), '#horizon');
        Horizon::night();
    }

    /**
     * Register the Horizon gate.
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            return $user->can('see horizon');
        });
    }
}
