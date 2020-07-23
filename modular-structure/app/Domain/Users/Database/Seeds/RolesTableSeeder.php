<?php

namespace App\Domain\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Users\Entities\Permission;
use App\Domain\Users\Entities\Role;

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
    }
}
