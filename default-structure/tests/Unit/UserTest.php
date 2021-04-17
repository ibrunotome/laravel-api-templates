<?php

namespace Tests\Unit;

use App\Models\AuthorizedDevice;
use App\Models\LoginHistory;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testLoginHistoriesRelationship()
    {
        LoginHistory::factory()->create(['user_id' => $this->user->id]);
        $this->assertNotNull($this->user->loginHistories);
    }

    public function testAuthorizedDevicesRelationship()
    {
        AuthorizedDevice::factory()->create(['user_id' => $this->user->id]);
        $this->assertNotNull($this->user->authorizedDevices);
    }
}
