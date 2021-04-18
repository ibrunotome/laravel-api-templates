<?php

namespace App\Domain\Users\Database\Factories;

use App\Domain\Users\Entities\LoginHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class LoginHistoryFactory extends Factory
{
    protected $model = LoginHistory::class;

    public function definition(): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
        ];
    }
}
