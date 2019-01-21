<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

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
