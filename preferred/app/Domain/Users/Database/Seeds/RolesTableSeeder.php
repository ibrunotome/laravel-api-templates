<?php

namespace Preferred\Domain\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use Preferred\Domain\Users\Entities\Permission;
use Preferred\Domain\Users\Entities\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ############
        # ADMIN
        ############

        $role = Role::create(['name' => Role::ADMIN]);
        $role->givePermissionTo(Permission::all());

        ############
        # TENANT
        ############

        Role::create(['name' => Role::TENANT]);

        ############
        # CLIENT
        ############

        Role::create(['name' => Role::CLIENT]);
    }
}
