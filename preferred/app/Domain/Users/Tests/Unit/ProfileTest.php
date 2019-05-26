<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Illuminate\Support\Facades\Queue;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * @var Profile
     */
    private $profile;

    public function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        $user = factory(User::class)->create();
        $this->profile = factory(Profile::class)->make(['user_id' => $user->id]);
    }

    public function testUserRelationship()
    {
        $this->assertNotNull($this->profile->user->id);
    }
}
