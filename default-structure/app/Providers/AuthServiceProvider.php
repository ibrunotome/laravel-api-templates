<?php

namespace App\Providers;

use App\Models\AuthorizedDevice;
use App\Models\LoginHistory;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\AuthorizedDevicePolicy;
use App\Policies\LoginHistoryPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        AuthorizedDevice::class => AuthorizedDevicePolicy::class,
        LoginHistory::class     => LoginHistoryPolicy::class,
        User::class             => UserPolicy::class,
        Permission::class       => PermissionPolicy::class,
        Role::class             => RolePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('spa_url') . '/reset-password?token=' . $token;
        });
    }
}
