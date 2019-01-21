<?php

namespace Preferred\Domain\Users\Database\Factories;

use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Infrastructure\Abstracts\AbstractModelFactory;
use Ramsey\Uuid\Uuid;

class AuthorizedDeviceFactory extends AbstractModelFactory
{
    protected $model = AuthorizedDevice::class;

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
                'brave'
            ]),
        ];
    }

    public function states()
    {
    }
}
