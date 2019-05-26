<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;

class NotificationControllerTest
{
    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testVisualizeAllNotifications()
    {
        $this->actingAs($this->user)
            ->patchJson(route('api.profile.notifications.visualize-all'))
            ->assertSuccessful()
            ->assertSee('OK');
    }
}
