<?php

namespace Tests\Feature;

use App\Listeners\UserRegisteredListener;
use App\Models\Profile;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserRegisteredListenerTest extends TestCase
{
    /**
     * @var UserRegisteredListener
     */
    private $userRegisteredListener;

    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRegisteredListener = $this->app->make(UserRegisteredListener::class);
        $this->user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testHandle()
    {
        Notification::fake();

        $this->userRegisteredListener->handle(new Registered($this->user));

        Notification::assertSentTo([$this->user], VerifyEmailNotification::class);
    }
}
