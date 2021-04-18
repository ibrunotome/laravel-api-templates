<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use App\Domain\Users\Listeners\UserRegisteredListener;
use App\Domain\Users\Notifications\VerifyEmailNotification;
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
