<?php

use Illuminate\Database\Seeder;
use App\Domain\Companies\Database\Seeds\CompaniesTableSeed;
use App\Domain\Users\Database\Seeds\PermissionsTableSeeder;
use App\Domain\Users\Database\Seeds\RolesTableSeeder;
use App\Domain\Users\Database\Seeds\UsersTableSeed;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompaniesTableSeed::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeed::class);
    }
}
