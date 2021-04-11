<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id'                          => Uuid::uuid4(),
            'name'                        => $this->faker->name,
            'anti_phishing_code'          => $this->faker->word,
            'email_token_confirmation'    => Uuid::uuid4(),
            'email_token_disable_account' => Uuid::uuid4(),
            'email'                       => $this->faker->unique()->email,
            'password'                    => bcrypt('secretxxx'),
            'is_active'                   => 1,
            'email_verified_at'           => now(),
            'locale'                      => 'en_US',
        ];
    }

    public function active(): UserFactory
    {
        return $this->state(fn() => ['is_active' => true]);
    }

    public function inactive(): UserFactory
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function emailVerified(): UserFactory
    {
        return $this->state(fn() => ['email_verified_at' => now()->format('Y-m-d H:i:s')]);
    }

    public function emailUnverified(): UserFactory
    {
        return $this->state(fn() => ['email_verified_at' => null]);
    }
}
