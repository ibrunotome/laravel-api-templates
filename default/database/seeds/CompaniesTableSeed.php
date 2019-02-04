<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class, 35)->create([]);
    }
}
