<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testLogin()
    {
        $this->postJson(route('api.auth.login'), [
            'email'    => $this->user->email,
            'password' => 'secretxxx',
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'token_type',
                    'expires_in',
                ],
                'meta'
            ]);
    }

    public function testFetchTheCurrentUser()
    {
        $this->actingAs($this->user)
            ->getJson(route('api.me'))
            ->assertSuccessful()
            ->assertJsonFragment([
                'email' => $this->user->email
            ]);
    }

    /**
     * @group logout
     */
    public function testLogout()
    {
        $token = $this->postJson(route('api.auth.login'), [
            'email'    => $this->user->email,
            'password' => 'secretxxx',
        ])->json()['data']['token'];

        $this->postJson('/api/logout?token=' . $token)
            ->assertSuccessful();

        $this->getJson('api/me?token=' . $token)
            ->assertStatus(401);
    }

    public function testCannotLoginBecauseEmailIsNotVerified()
    {
        $this->user = factory(User::class)->create(['email_verified_at' => null]);

        factory(Profile::class)->create(['user_id' => $this->user->id]);

        $this->postJson(route('api.auth.login'), [
            'email'    => $this->user->email,
            'password' => 'secretxxx',
        ])->assertStatus(423);
    }

    public function testCannotLoginBecauseAccountIsInactive()
    {
        $this->user = factory(User::class)->create(['is_active' => 0]);

        factory(Profile::class)->create(['user_id' => $this->user->id]);

        $this->postJson(route('api.auth.login'), [
            'email'    => $this->user->email,
            'password' => 'secretxxx',
        ])->assertStatus(423);
    }
}
