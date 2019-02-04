<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Models\Company::class, function (Faker $faker) {
    return [
        'id'        => Uuid::uuid4(),
        'name'      => $this->faker->company,
        'is_active' => 1,
        'max_users' => rand(1, 32767)
    ];
});
