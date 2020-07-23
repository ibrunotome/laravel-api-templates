<?php

namespace App\Domain\Users\Tests\Unit;

use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\User;
use Tests\TestCase;

class LoginHistoryTest extends TestCase
{
    private LoginHistory $loginHistory;

    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->loginHistory = factory(LoginHistory::class)->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->loginHistory->user->id);
    }
}
