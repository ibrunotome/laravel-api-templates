<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'id'                          => Uuid::uuid4(),
        'name'                        => $faker->name,
        'anti_phishing_code'          => $faker->word,
        'email_token_confirmation'    => Uuid::uuid4(),
        'email_token_disable_account' => Uuid::uuid4(),
        'email'                       => strtolower(str_replace('-', '', Uuid::uuid4())) . '@gmail.com',
        'password'                    => bcrypt('secretxxx'),
        'is_active'                   => 1,
        'email_verified_at'           => now(),
        'locale'                      => 'en_US',
    ];
});

$factory->state(App\Models\User::class, 'active', function () {
    return [
        'is_active' => true,
    ];
});

$factory->state(App\Models\User::class, 'inactive', function () {
    return [
        'is_active' => false,
    ];
});

$factory->state(App\Models\User::class, 'email_verified', function () {
    return [
        'email_verified_at' => now()->format('Y-m-d H:i:s'),
    ];
});

$factory->state(App\Models\User::class, 'email_unverified', function () {
    return [
        'email_verified_at' => null,
    ];
});
