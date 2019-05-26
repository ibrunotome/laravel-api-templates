<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
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
