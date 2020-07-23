<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
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
