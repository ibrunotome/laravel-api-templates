<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Models\LoginHistory::class, function (Faker $faker) {
    return [
        'id' => Uuid::uuid4(),
    ];
});
