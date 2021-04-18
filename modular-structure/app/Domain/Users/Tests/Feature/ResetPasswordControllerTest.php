<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use App\Domain\Users\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testSubmitPasswordReset()
    {
        $token = Password::broker()->createToken($this->user);
        $password = $this->faker->password(12);

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->user->email,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertSuccessful();

        $this->user->refresh();

        $this->assertFalse(Hash::check('secretxxx', $this->user->password));
        $this->assertTrue(Hash::check($password, $this->user->password));
    }

    public function testSubmitPasswordResetRequestInvalidEmail()
    {
        $this
            ->post(route('api.reset.email-link'), [
                'email' => $this->faker->word,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testSubmitPasswordResetRequestEmailNotFound()
    {
        $this
            ->post(route('api.reset.email-link'), [
                'email' => $this->faker->unique()->safeEmail,
            ])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Testing submitting a password reset request.
     */
    public function testSubmitPasswordResetRequest()
    {
        $this
            ->post(route('api.reset.email-link'), [
                'email' => $this->user->email,
            ])
            ->assertOk();

        Notification::assertSentTo($this->user, ResetPasswordNotification::class);
    }

    /**
     * Testing submitting the password reset page with an invalid
     * email address.
     */
    public function testSubmitPasswordResetInvalidEmail()
    {
        $token = Password::broker()->createToken($this->user);

        $password = $this->faker->password(12);

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->faker->word,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }

    /**
     * Testing submitting the password reset page with an email
     * address not in the database.
     */
    public function testSubmitPasswordResetEmailNotFound()
    {
        $token = Password::broker()->createToken($this->user);

        $password = $this->faker->password(12);

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->faker->unique()->safeEmail,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }

    public function testSubmitPasswordResetPasswordMismatch()
    {
        $token = Password::broker()->createToken($this->user);
        $password = $this->faker->password(12);
        $password_confirmation = $this->faker->password(12);

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->user->email,
                'password'              => $password,
                'password_confirmation' => $password_confirmation,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }

    public function testSubmitPasswordResetPasswordTooShort()
    {
        $token = Password::broker()->createToken($this->user);
        $password = $this->faker->lexify('?????');

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->user->email,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }
}
