<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Notifications\ResetPasswordNotification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use WithFaker;

    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testSubmitPasswordReset()
    {
        $token = Password::broker()->createToken($this->user);
        $password = str_random();

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
                'email' => str_random(),
            ])
            ->assertStatus(422);
    }

    public function testSubmitPasswordResetRequestEmailNotFound()
    {
        $this
            ->post(route('api.reset.email-link'), [
                'email' => $this->faker->unique()->safeEmail,
            ])
            ->assertStatus(400);
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
            ->assertSuccessful();

        Notification::assertSentTo($this->user, ResetPasswordNotification::class);
    }

    /**
     * Testing submitting the password reset page with an invalid
     * email address.
     */
    public function testSubmitPasswordResetInvalidEmail()
    {
        $token = Password::broker()->createToken($this->user);

        $password = str_random();

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => str_random(),
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(422);

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

        $password = str_random();

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->faker->unique()->safeEmail,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(400);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }

    public function testSubmitPasswordResetPasswordMismatch()
    {
        $token = Password::broker()->createToken($this->user);
        $password = str_random();
        $password_confirmation = str_random();

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->user->email,
                'password'              => $password,
                'password_confirmation' => $password_confirmation,
            ])
            ->assertStatus(422);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }

    public function testSubmitPasswordResetPasswordTooShort()
    {
        $token = Password::broker()->createToken($this->user);
        $password = str_random(5);

        $this
            ->post(route('api.reset.password'), [
                'token'                 => $token,
                'email'                 => $this->user->email,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(422);

        $this->user->refresh();

        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('secretxxx', $this->user->password));
    }
}
