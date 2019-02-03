<?php

namespace Preferred\Domain\Users\Providers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Neves\Events\Contracts\TransactionalEvent;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Permission;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\Role;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Events\TwoFactorAuthenticationWasDisabled;
use Preferred\Domain\Users\Listeners\Observers\AuthorizedDeviceObserver;
use Preferred\Domain\Users\Listeners\Observers\LoginHistoryObserver;
use Preferred\Domain\Users\Listeners\Observers\PermissionObserver;
use Preferred\Domain\Users\Listeners\Observers\ProfileObserver;
use Preferred\Domain\Users\Listeners\Observers\RoleObserver;
use Preferred\Domain\Users\Listeners\Observers\UserObserver;
use Preferred\Domain\Users\Listeners\PasswordResetListener;
use Preferred\Domain\Users\Listeners\TwoFactorAuthenticationWasDisabledListener;
use Preferred\Domain\Users\Listeners\UserRegisteredListener;

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
            TwoFactorAuthenticationWasDisabledListener::class
        ]
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
        Profile::observe(ProfileObserver::class);
        Role::observe(RoleObserver::class);
        User::observe(UserObserver::class);

        //
    }
}
