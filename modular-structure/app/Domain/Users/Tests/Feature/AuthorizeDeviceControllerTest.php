<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\User;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class AuthorizeDeviceControllerTest extends TestCase
{
    public function testAuthorizeDevice()
    {
        $user = User::factory()->emailUnverified()->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $authorizedDevice = AuthorizedDevice::factory()->create([
            'device'           => 'device',
            'platform'         => 'platform',
            'platform_version' => 'platform_version',
            'browser'          => 'browser',
            'browser_version'  => 'browser_version',
            'authorized_at'    => null,
            'user_id'          => $user->id,
        ]);

        $this->postJson(route('api.device.authorize', $authorizedDevice->authorization_token))
            ->assertOk()
            ->assertSee('Device\/location successfully authorized');
    }

    public function testCannotAuthorizeDeviceBecauseItsAlreadyAuthorized()
    {
        User::factory()->emailUnverified()->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $this->postJson(route('api.device.authorize', Uuid::uuid4()->toString()))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertSee('Invalid token for authorize new device\/location');
    }

    public function testDestroyAuthorizedDevice()
    {
        $user = User::factory()->emailUnverified()->create([
            'email'    => 'test@test.com',
            'password' => bcrypt('secretxxx'),
        ]);

        $authorizedDevice = AuthorizedDevice::factory()->create([
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
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
