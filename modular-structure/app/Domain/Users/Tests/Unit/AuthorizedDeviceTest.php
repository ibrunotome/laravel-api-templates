<?php

namespace App\Domain\Users\Tests\Unit;

use App\Domain\Users\Entities\AuthorizedDevice;
use App\Domain\Users\Entities\User;
use Tests\TestCase;

class AuthorizedDeviceTest extends TestCase
{
    private AuthorizedDevice $authorizedDevice;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->authorizedDevice = AuthorizedDevice::factory()->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->authorizedDevice->user->id);
    }
}
