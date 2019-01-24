<?php

use Illuminate\Database\Seeder;
use Preferred\Domain\Users\Database\Seeds\PermissionsTableSeeder;
use Preferred\Domain\Users\Database\Seeds\RolesTableSeeder;
use Preferred\Domain\Users\Database\Seeds\UsersTableSeed;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeed::class);
    }
}
