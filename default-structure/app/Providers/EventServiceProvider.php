<?php

namespace App\Providers;

use App\Events\TwoFactorAuthenticationWasDisabled;
use App\Listeners\Observers\AuditObserver;
use App\Listeners\Observers\AuthorizedDeviceObserver;
use App\Listeners\Observers\LoginHistoryObserver;
use App\Listeners\Observers\PermissionObserver;
use App\Listeners\Observers\RoleObserver;
use App\Listeners\Observers\UserObserver;
use App\Listeners\PasswordResetListener;
use App\Listeners\TwoFactorAuthenticationWasDisabledListener;
use App\Listeners\UserRegisteredListener;
use App\Models\Audit;
use App\Models\AuthorizedDevice;
use App\Models\LoginHistory;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
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
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        Audit::observe(AuditObserver::class);
        User::observe(UserObserver::class);
        AuthorizedDevice::observe(AuthorizedDeviceObserver::class);
        LoginHistory::observe(LoginHistoryObserver::class);
        Permission::observe(PermissionObserver::class);
        Role::observe(RoleObserver::class);
    }
}
