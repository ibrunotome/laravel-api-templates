<?php

namespace Tests\Feature;

use App\Models\AuthorizedDevice;
use App\Models\Profile;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AuthorizeDeviceControllerTest extends TestCase
{
    public function testAuthorizeDevice()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->states([
            'email_unverified',
        ])->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        /**
         * @var AuthorizedDevice $authorizedDevice
         */
        $authorizedDevice = factory(AuthorizedDevice::class)->create([
            'device'           => 'device',
            'platform'         => 'platform',
            'platform_version' => 'platform_version',
            'browser'          => 'browser',
            'browser_version'  => 'browser_version',
            'authorized_at'    => null,
            'user_id'          => $user->id,
        ]);

        $this->postJson(route('api.device.authorize', $authorizedDevice->authorization_token))
            ->assertStatus(200)
            ->assertSee('Device\/location successfully authorized');
    }

    public function testCannotAuthorizeDeviceBecauseItsAlreadyAuthorized()
    {
        /**
         * @var User $user
         */
        factory(User::class)->states([
            'email_unverified',
        ])->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $this->postJson(route('api.device.authorize', Uuid::uuid4()->toString()))
            ->assertStatus(400)
            ->assertSee('Invalid token for authorize new device\/location');
    }

    public function testDestroyAuthorizedDevice()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->states([
            'email_unverified',
        ])->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        factory(Profile::class)->create(['user_id' => $user->id]);

        /**
         * @var AuthorizedDevice $authorizedDevice
         */
        $authorizedDevice = factory(AuthorizedDevice::class)->create([
            'device'           => 'device',
            'platform'         => 'platform',
            'platform_version' => 'platform_version',
            'browser'          => 'browser',
            'browser_version'  => 'browser_version',
            'authorized_at'    => null,
            'user_id'          => $user->id,
        ]);

        $this
            ->actingAs($user)
            ->deleteJson(route('api.device.destroy', $authorizedDevice->id))
            ->assertStatus(204);
    }
}
