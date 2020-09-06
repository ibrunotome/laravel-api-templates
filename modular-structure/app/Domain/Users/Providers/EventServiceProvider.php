<?php

namespace App\Domain\Users\Providers;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\Permission;
use App\Domain\Users\Entities\Role;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Events\TwoFactorAuthenticationWasDisabled;
use App\Domain\Users\Listeners\Observers\AuthorizedDeviceObserver;
use App\Domain\Users\Listeners\Observers\LoginHistoryObserver;
use App\Domain\Users\Listeners\Observers\PermissionObserver;
use App\Domain\Users\Listeners\Observers\RoleObserver;
use App\Domain\Users\Listeners\Observers\UserObserver;
use App\Domain\Users\Listeners\PasswordResetListener;
use App\Domain\Users\Listeners\TwoFactorAuthenticationWasDisabledListener;
use App\Domain\Users\Listeners\UserRegisteredListener;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Neves\Events\Contracts\TransactionalEvent;

class EventServiceProvider extends ServiceProvider implements TransactionalEvent
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

        PasswordReset::class => [
            PasswordResetListener::class,
        ],

        TwoFactorAuthenticationWasDisabled::class => [
            TwoFactorAuthenticationWasDisabledListener::class,
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

        AuthorizedDevice::observe(AuthorizedDeviceObserver::class);
        LoginHistory::observe(LoginHistoryObserver::class);
        Permission::observe(PermissionObserver::class);
        Role::observe(RoleObserver::class);
        User::observe(UserObserver::class);
    }
}
