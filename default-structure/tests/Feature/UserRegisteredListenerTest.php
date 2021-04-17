<?php

namespace Tests\Feature;

use App\Listeners\UserRegisteredListener;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserRegisteredListenerTest extends TestCase
{
    private UserRegisteredListener $userRegisteredListener;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRegisteredListener = $this->app->make(UserRegisteredListener::class);
        $this->user = User::factory()->create();
    }

    public function testHandle()
    {
        Notification::fake();

        $this->userRegisteredListener->handle(new Registered($this->user));

        Notification::assertSentTo([$this->user], VerifyEmailNotification::class);
    }
}
