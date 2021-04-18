<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
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
            ->assertStatus(Response::HTTP_CREATED)
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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('The password confirmation does not match');
    }

    public function testCannotRegisterBecauseEmailAlreadyRegistered()
    {
        User::factory()->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $this->postJson(route('api.auth.register'), [
            'email'                 => 'test@test.com',
            'password'              => 'secretxxx-test',
            'password_confirmation' => 'secretxxx-test',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('email has already been taken');
    }

    public function testVerifyEmail()
    {
        $user = User::factory()->create([
            'is_active'                => 1,
            'email_verified_at'        => null,
            'email_token_confirmation' => Uuid::uuid4(),
            'email'                    => 'test@test.com',
            'password'                 => bcrypt('secretxxx'),
        ]);

        $this->post(route('api.email.verify', [$user->email_token_confirmation]))
            ->assertOk()
            ->assertSee('Email successfully verified');
    }

    public function testInvalidVerifyEmailToken()
    {
        User::factory()->create([
            'is_active'         => 1,
            'email_verified_at' => null,
            'email'             => 'test@test.com',
            'password'          => bcrypt('secretxxx'),
        ]);

        $this->post(route('api.email.verify', [Uuid::uuid4()]))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertSee('Invalid token for email verification');
    }
}
