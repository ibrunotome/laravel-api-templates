<?php

namespace App\Application\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        Horizon::routeSlackNotificationsTo(config('services.SLACK_WEBHOOK_URL'), '#horizon');
        Horizon::night();
    }

    /**
     * {@inheritdoc}
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            return $user->can('see horizon');
        });
    }
}
