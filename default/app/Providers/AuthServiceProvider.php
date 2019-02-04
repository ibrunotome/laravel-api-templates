<?php

namespace App\Providers;

use App\Models\AuthorizedDevice;
use App\Models\Company;
use App\Models\LoginHistory;
use App\Models\Permission;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Policies\AuthorizedDevicePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\LoginHistoryPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AuthorizedDevice::class => AuthorizedDevicePolicy::class,
        Company::class          => CompanyPolicy::class,
        LoginHistory::class     => LoginHistoryPolicy::class,
        User::class             => UserPolicy::class,
        Profile::class          => ProfilePolicy::class,
        Permission::class       => PermissionPolicy::class,
        Role::class             => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
