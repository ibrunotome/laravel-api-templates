<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testVisualizeAllNotifications()
    {
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.notifications.visualize-all'))
            ->assertOk()
            ->assertSee('OK');
    }
}
