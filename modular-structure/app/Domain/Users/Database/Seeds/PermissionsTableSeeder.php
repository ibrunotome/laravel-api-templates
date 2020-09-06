<?php

namespace App\Domain\Users\Database\Seeds;

use App\Domain\Users\Entities\Permission;
use Illuminate\Database\Seeder;

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
            'authorized devices',
            'companies',
            'login histories',
            'permissions',
            'roles',
            'users',
        ])->each(function ($type) {
            $this->createPermissions($type);
        });
    }

    private function createPermissions($type)
    {
        Permission::create(['name' => "view any {$type}"]);
        Permission::create(['name' => "view {$type}"]);
        Permission::create(['name' => "create {$type}"]);
        Permission::create(['name' => "update {$type}"]);
        Permission::create(['name' => "delete {$type}"]);
        Permission::create(['name' => "restore {$type}"]);
        Permission::create(['name' => "force delete {$type}"]);
    }
}
