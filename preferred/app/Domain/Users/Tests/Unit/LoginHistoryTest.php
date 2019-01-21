<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class LoginHistoryTest extends TestCase
{
    /** @var LoginHistory */
    private $loginHistory;

    public function setUp()
    {
        parent::setUp();

        Queue::fake();
        Notification::fake();

        $user = factory(User::class)->create();
        $this->loginHistory = factory(LoginHistory::class)->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->loginHistory->user->id);
    }
}
