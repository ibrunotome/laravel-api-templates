<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Models\AuthorizedDevice::class, function (Faker $faker) {
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
});
