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

        $user = factory(User::class)->create();
        $this->authorizedDevice = factory(AuthorizedDevice::class)->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->authorizedDevice->user->id);
    }
}
