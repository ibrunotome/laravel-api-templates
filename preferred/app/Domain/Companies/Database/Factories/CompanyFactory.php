<?php

namespace Preferred\Domain\Companies\Database\Factories;

use Preferred\Domain\Companies\Entities\Company;
use Preferred\Infrastructure\Abstracts\AbstractModelFactory;
use Ramsey\Uuid\Uuid;

class CompanyFactory extends AbstractModelFactory
{
    protected $model = Company::class;

    public function fields()
    {
        return [
            'id'        => Uuid::uuid4(),
            'name'      => $this->faker->company,
            'is_active' => 1,
            'max_users' => rand(1, 32767)
        ];
    }

    public function states()
    {
    }
}
