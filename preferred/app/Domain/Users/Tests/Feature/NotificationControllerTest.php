<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
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
        $this
            ->actingAs($this->user)
            ->patchJson(route('api.notifications.visualize-all'))
            ->assertSuccessful()
            ->assertSee('OK');
    }
}
