<?php

namespace App\Domain\Users\Database\Factories;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Infrastructure\Abstracts\ModelFactory;
use Ramsey\Uuid\Uuid;

class AuthorizedDeviceFactory extends ModelFactory
{
    protected string $model = AuthorizedDevice::class;

    public function fields()
    {
        return [
            'id'                  => Uuid::uuid4(),
            'authorization_token' => Uuid::uuid4(),
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

    public function states()
    {
    }
}
