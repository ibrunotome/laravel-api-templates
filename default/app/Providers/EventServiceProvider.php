<?php

namespace App\Providers;

use App\Listeners\Observers\AuditObserver;
use App\Listeners\Observers\ProfileObserver;
use App\Listeners\Observers\UserObserver;
use App\Listeners\UserRegisteredListener;
use App\Models\Audit;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            UserRegisteredListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Audit::observe(AuditObserver::class);
        User::observe(UserObserver::class);
        Profile::observe(ProfileObserver::class);

        //
    }
}
