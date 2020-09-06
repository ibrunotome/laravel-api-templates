<?php

namespace App\Domain\Users\Database\Seeds;

use App\Domain\Users\Entities\Permission;
use App\Domain\Users\Entities\Role;
use Illuminate\Database\Seeder;

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
