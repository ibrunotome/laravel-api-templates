<?php

namespace Preferred\Domain\Companies\Database\Seeds;

use Illuminate\Database\Seeder;
use Preferred\Domain\Companies\Entities\Company;

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
