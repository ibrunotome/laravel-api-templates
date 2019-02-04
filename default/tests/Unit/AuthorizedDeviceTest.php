<?php

namespace Tests\Unit;

use App\Models\AuthorizedDevice;
use App\Models\User;
use Tests\TestCase;

class AuthorizedDeviceTest extends TestCase
{
    /** @var AuthorizedDevice */
    private $authorizedDevice;

    public function setUp()
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
