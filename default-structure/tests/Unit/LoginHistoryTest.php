<?php

namespace Tests\Unit;

use App\Models\LoginHistory;
use App\Models\User;
use Tests\TestCase;

class LoginHistoryTest extends TestCase
{
    private LoginHistory $loginHistory;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->loginHistory = LoginHistory::factory()->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->loginHistory->user->id);
    }
}
