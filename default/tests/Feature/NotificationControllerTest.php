<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;

class NotificationControllerTest
{
    /** @var User */
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
