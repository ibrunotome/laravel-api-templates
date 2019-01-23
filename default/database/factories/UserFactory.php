<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'id'                => Uuid::uuid4(),
        'email'             => strtolower(str_replace('-', '', Uuid::uuid4())) . '@gmail.com',
        'password'          => $password ?: $password = bcrypt('secretxxx'),
        'is_active'         => 1,
        'email_verified_at' => now(),
    ];
});
