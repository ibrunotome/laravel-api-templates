<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'email'             => $faker->unique()->safeEmail,
        'is_active'         => 1,
        'email_verified_at' => now(),
        'password'          => bcrypt('secretxxx'),
        'remember_token'    => str_random(10),
    ];
});
