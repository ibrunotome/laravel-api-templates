<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
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

    public function testLogin()
    {
        $this
            ->postJson(route('api.auth.login'), [
                'email'    => $this->user->email,
                'password' => 'secretxxx',
            ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'tokenType',
                    'expiresIn',
                ],
                'meta',
            ]);
    }

    public function testFetchTheCurrentUser()
    {
        $this
            ->actingAs($this->user)
            ->getJson(route('api.me'))
            ->assertSuccessful()
            ->assertJsonFragment([
                'email'  => $this->user->email,
                'locale' => $this->user->locale,
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

        $this
            ->postJson(route('api.auth.logout') . '?token=' . $token)
            ->assertSuccessful();

        $this
            ->getJson(route('api.me') . '?token=' . $token)
            ->assertStatus(401);
    }

    public function testCannotLoginBecauseEmailIsNotVerified()
    {
        $this->user = factory(User::class)->states('email_unverified')->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);

        $this
            ->postJson(route('api.auth.login'), [
                'email'    => $this->user->email,
                'password' => 'secretxxx',
            ])
            ->assertStatus(423);
    }

    public function testCannotLoginBecauseAccountIsInactive()
    {
        $this->user = factory(User::class)->states('inactive')->create();

        $this
            ->postJson(route('api.auth.login'), [
                'email'    => $this->user->email,
                'password' => 'secretxxx',
            ])
            ->assertStatus(423);
    }
}
