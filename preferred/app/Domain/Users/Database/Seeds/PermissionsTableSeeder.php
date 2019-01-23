<?php

namespace Preferred\Domain\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Preferred\Domain\Users\Entities\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('cache')->forget('spatie.permission.cache');

        # Users
        Permission::create(['name' => 'users_view_any']);
        Permission::create(['name' => 'users_view']);
        Permission::create(['name' => 'users_create']);
        Permission::create(['name' => 'users_update']);
        Permission::create(['name' => 'users_delete']);
        Permission::create(['name' => 'users_restore']);
        Permission::create(['name' => 'users_force_delete']);

        # Profiles
        Permission::create(['name' => 'profiles_view_any']);
        Permission::create(['name' => 'profiles_view']);
        Permission::create(['name' => 'profiles_create']);
        Permission::create(['name' => 'profiles_update']);
        Permission::create(['name' => 'profiles_delete']);
        Permission::create(['name' => 'profiles_restore']);
        Permission::create(['name' => 'profiles_force_delete']);

        # Authorized Devices
        Permission::create(['name' => 'authorized_devices_view_any']);
        Permission::create(['name' => 'authorized_devices_view']);
        Permission::create(['name' => 'authorized_devices_create']);
        Permission::create(['name' => 'authorized_devices_update']);
        Permission::create(['name' => 'authorized_devices_delete']);
        Permission::create(['name' => 'authorized_devices_restore']);
        Permission::create(['name' => 'authorized_devices_force_delete']);

        # Login Histories
        Permission::create(['name' => 'login_histories_view_any']);
        Permission::create(['name' => 'login_histories_view']);
        Permission::create(['name' => 'login_histories_create']);
        Permission::create(['name' => 'login_histories_update']);
        Permission::create(['name' => 'login_histories_delete']);
        Permission::create(['name' => 'login_histories_restore']);
        Permission::create(['name' => 'login_histories_force_delete']);

        # Roles
        Permission::create(['name' => 'roles_view_any']);
        Permission::create(['name' => 'roles_view']);
        Permission::create(['name' => 'roles_create']);
        Permission::create(['name' => 'roles_update']);
        Permission::create(['name' => 'roles_delete']);
        Permission::create(['name' => 'roles_restore']);
        Permission::create(['name' => 'roles_force_delete']);

        # Permissions
        Permission::create(['name' => 'permissions_view_any']);
        Permission::create(['name' => 'permissions_view']);
        Permission::create(['name' => 'permissions_create']);
        Permission::create(['name' => 'permissions_update']);
        Permission::create(['name' => 'permissions_delete']);
        Permission::create(['name' => 'permissions_restore']);
        Permission::create(['name' => 'permissions_force_delete']);
    }
}
