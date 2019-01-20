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

$factory->define(App\Models\Profile::class, function (Faker $faker) {
    return [
        'id'                          => Uuid::uuid4(),
        'name'                        => $faker->name,
        'anti_phishing_code'          => null,
        'email_token_confirmation'    => Uuid::uuid4(),
        'email_token_disable_account' => Uuid::uuid4(),
    ];
});
