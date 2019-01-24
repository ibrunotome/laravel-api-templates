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

        collect([
            'users',
            'profiles',
            'authorized devices',
            'login histories',
            'roles',
            'permissions',
        ])->each(function ($type) {
            $this->createPermissions($type);
        });
    }

    private function createPermissions($type)
    {
        Permission::create(['name' => "view {$type}"]);
        Permission::create(['name' => "create {$type}"]);
        Permission::create(['name' => "update {$type}"]);
        Permission::create(['name' => "delete {$type}"]);
        Permission::create(['name' => "restore {$type}"]);
        Permission::create(['name' => "force delete {$type}"]);
    }
}
