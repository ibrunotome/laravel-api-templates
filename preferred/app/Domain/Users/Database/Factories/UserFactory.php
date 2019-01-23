<?php

namespace Preferred\Domain\Users\Database\Factories;

use Preferred\Domain\Users\Entities\User;
use Preferred\Infrastructure\Abstracts\AbstractModelFactory;
use Ramsey\Uuid\Uuid;

class UserFactory extends AbstractModelFactory
{
    protected $model = User::class;

    public function fields()
    {
        static $password;

        return [
            'id'                => Uuid::uuid4(),
            'email'             => strtolower(str_replace('-', '', Uuid::uuid4())) . '@gmail.com',
            'password'          => $password ?: $password = bcrypt('secretxxx'),
            'is_active'         => 1,
            'email_verified_at' => now(),
        ];
    }

    public function states()
    {
    }
}
