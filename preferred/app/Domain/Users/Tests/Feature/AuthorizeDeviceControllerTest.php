<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class AuthorizeDeviceControllerTest extends TestCase
{
    public function testAuthorizeDevice()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'is_active'         => 1,
            'email_verified_at' => null,
            'email'             => 'test@test.com',
            'password'          => bcrypt('secretxxx'),
        ]);

        factory(Profile::class)->create(['user_id' => $user->id]);

        /** @var AuthorizedDevice $authorizedDevice */
        $authorizedDevice = factory(AuthorizedDevice::class)->create([
            'device'           => 'device',
            'platform'         => 'platform',
            'platform_version' => 'platform_version',
            'browser'          => 'browser',
            'browser_version'  => 'browser_version',
            'authorized_at'    => null,
            'user_id'          => $user->id,
        ]);

        $this->postJson('/api/devices/authorize/' . $authorizedDevice->authorization_token)
            ->assertStatus(200)
            ->assertSee('Device\/location successfully authorized');
    }

    public function testCannotAuthorizeDeviceBecauseItsAlreadyAuthorized()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'is_active'         => 1,
            'email_verified_at' => null,
            'email'             => 'test@test.com',
            'password'          => bcrypt('secretxxx'),
        ]);

        factory(Profile::class)->create(['user_id' => $user->id]);

        /** @var AuthorizedDevice $authorizedDevice */
        $authorizedDevice = factory(AuthorizedDevice::class)->create([
            'device'           => 'device',
            'platform'         => 'platform',
            'platform_version' => 'platform_version',
            'browser'          => 'browser',
            'browser_version'  => 'browser_version',
            'authorized_at'    => now(),
            'user_id'          => $user->id,
        ]);

        $this->postJson('/api/devices/authorize/' . $authorizedDevice->authorization_token)
            ->assertStatus(400)
            ->assertSee('Invalid token for authorize new device\/location');
    }

    public function testDestroyAuthorizedDevice()
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'is_active'         => 1,
            'email_verified_at' => null,
            'email'             => 'test@test.com',
            'password'          => bcrypt('secretxxx'),
        ]);

        factory(Profile::class)->create(['user_id' => $user->id]);

        /** @var AuthorizedDevice $authorizedDevice */
        $authorizedDevice = factory(AuthorizedDevice::class)->create([
            'device'           => 'device',
            'platform'         => 'platform',
            'platform_version' => 'platform_version',
            'browser'          => 'browser',
            'browser_version'  => 'browser_version',
            'authorized_at'    => null,
            'user_id'          => $user->id,
        ]);

        $this->actingAs($user)
            ->deleteJson('/api/devices/' . $authorizedDevice->id)
            ->assertStatus(204);
    }
}
