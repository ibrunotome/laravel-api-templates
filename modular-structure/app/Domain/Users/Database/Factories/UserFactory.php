<?php

namespace App\Domain\Users\Database\Factories;

use App\Domain\Users\Entities\User;
use App\Infrastructure\Abstracts\ModelFactory;
use Ramsey\Uuid\Uuid;

class UserFactory extends ModelFactory
{
    protected string $model = User::class;

    public function fields()
    {
        return [
            'id'                          => Uuid::uuid4()->toString(),
            'email'                       => strtolower(str_replace('-', '', Uuid::uuid4()->toString())) . '@gmail.com',
            'password'                    => bcrypt('secretxxx'),
            'is_active'                   => true,
            'email_verified_at'           => now(),
            'locale'                      => 'en_US',
            'name'                        => $this->faker->name,
            'anti_phishing_code'          => $this->faker->word,
            'email_token_confirmation'    => Uuid::uuid4(),
            'email_token_disable_account' => Uuid::uuid4(),
        ];
    }

    public function states()
    {
        $this->factory->state($this->model, 'active', function () {
            return [
                'is_active' => true,
            ];
        });

        $this->factory->state($this->model, 'inactive', function () {
            return [
                'is_active' => false,
            ];
        });

        $this->factory->state($this->model, 'email_verified', function () {
            return [
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
            ];
        });

        $this->factory->state($this->model, 'email_unverified', function () {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
