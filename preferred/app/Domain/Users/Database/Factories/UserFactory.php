<?php

namespace Preferred\Domain\Users\Database\Factories;

use Preferred\Domain\Users\Entities\User;
use Preferred\Infrastructure\Abstracts\AbstractModelFactory;

class UserFactory extends AbstractModelFactory
{
    protected $model = User::class;

    public function fields()
    {
        return [
            'email'             => $this->faker->unique()->safeEmail,
            'is_active'         => 1,
            'email_verified_at' => now(),
            'password'          => bcrypt('secretxxx'),
            'remember_token'    => str_random(10),
        ];
    }

    public function states()
    {
    }
}
