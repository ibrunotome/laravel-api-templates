<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testCanRegister()
    {
        $this->postJson(route('api.auth.register'), [
            'name'                  => 'test',
            'email'                 => 'test@test.com',
            'password'              => 'secretxxx-test',
            'password_confirmation' => 'secretxxx-test',
        ])
            ->assertStatus(201)
            ->assertSee('We sent a confirmation email to test@test.com');
    }

    public function testCannotRegisterBecausePasswordIsTooShort()
    {
        $this->postJson(route('api.auth.register'), [
            'name'                  => 'test',
            'email'                 => 'test@test.com',
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ])
            ->assertStatus(422)
            ->assertSee('The password must be at least 8 characters');
    }

    public function testCannotRegisterBecausePasswordIsWeak()
    {
        $this->postJson(route('api.auth.register'), [
            'name'                  => 'test',
            'email'                 => 'test@test.com',
            'password'              => 'secretxxx',
            'password_confirmation' => 'secretxxx',
        ])
            ->assertStatus(422)
            ->assertSee('This password is just too common. Please try another!');
    }

    public function testCannotRegisterBecausePasswordsNotMatch()
    {
        $this->postJson(route('api.auth.register'), [
            'name'                  => 'test',
            'email'                 => 'test@test.com',
            'password'              => 'secretxxx1',
            'password_confirmation' => 'secretxxx2',
        ])
            ->assertStatus(422)
            ->assertSee('The password confirmation does not match');
    }

    public function testCannotRegisterBecauseEmailAlreadyRegistered()
    {
        factory(User::class)->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $this->postJson(route('api.auth.register'), [
            'email'                 => 'test@test.com',
            'password'              => 'secretxxx-test',
            'password_confirmation' => 'secretxxx-test',
        ])
            ->assertStatus(422)
            ->assertSee('email has already been taken');
    }

    public function testVerifyEmail()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->create([
            'is_active'         => 1,
            'email_verified_at' => null,
            'email'             => 'test@test.com',
            'password'          => bcrypt('secretxxx'),
        ]);

        /**
         * @var Profile $profile
         */
        $profile = factory(Profile::class)->create([
            'user_id'                  => $user->id,
            'email_token_confirmation' => Uuid::uuid4(),
        ]);

        $this->post(route('api.email.verify', [$profile->email_token_confirmation]))
            ->assertStatus(200)
            ->assertSee('Email successfully verified');
    }

    public function testInvalidVerifyEmailToken()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->create([
            'is_active'         => 1,
            'email_verified_at' => null,
            'email'             => 'test@test.com',
            'password'          => bcrypt('secretxxx'),
        ]);

        factory(Profile::class)->create([
            'user_id'                  => $user->id,
            'email_token_confirmation' => Uuid::uuid4(),
        ]);

        $this->post(route('api.email.verify', [Uuid::uuid4()]))
            ->assertStatus(400)
            ->assertSee('Invalid token for email verification');
    }
}
