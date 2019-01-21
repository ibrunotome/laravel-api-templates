<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Models\Profile::class, function (Faker $faker) {
    return [
        'id'                          => Uuid::uuid4(),
        'name'                        => $faker->name,
        'anti_phishing_code'          => $faker->word,
        'email_token_confirmation'    => Uuid::uuid4(),
        'email_token_disable_account' => Uuid::uuid4(),
    ];
});
