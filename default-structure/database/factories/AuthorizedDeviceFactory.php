<?php

namespace Database\Factories;

use App\Models\AuthorizedDevice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class AuthorizedDeviceFactory extends Factory
{
    protected $model = AuthorizedDevice::class;

    public function definition(): array
    {
        return [
            'id'                  => Uuid::uuid4()->toString(),
            'authorization_token' => Uuid::uuid4()->toString(),
            'device'              => $this->faker->phoneNumber,
            'platform'            => $this->faker->phoneNumber,
            'browser'             => $this->faker->randomElement([
                'safari',
                'chrome',
                'firefox',
                'brave',
            ]),
        ];
    }
}

