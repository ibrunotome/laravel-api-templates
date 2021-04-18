<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
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
            ->assertOk()
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
            ->assertUnauthorized();
    }

    public function testCannotLoginBecauseEmailIsNotVerified()
    {
        $this->user = User::factory()->emailUnverified()->create();

        $this
            ->postJson(route('api.auth.login'), [
                'email'    => $this->user->email,
                'password' => 'secretxxx',
            ])
            ->assertStatus(Response::HTTP_LOCKED);
    }

    public function testCannotLoginBecauseAccountIsInactive()
    {
        $this->user = User::factory()->inactive()->create();

        $this
            ->postJson(route('api.auth.login'), [
                'email'    => $this->user->email,
                'password' => 'secretxxx',
            ])
            ->assertStatus(Response::HTTP_LOCKED);
    }
}
