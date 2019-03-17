<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Listeners\UserRegisteredListener;
use Preferred\Domain\Users\Notifications\VerifyEmailNotification;
use Tests\TestCase;

class UserRegisteredListenerTest extends TestCase
{
    /** @var UserRegisteredListener */
    private $userRegisteredListener;

    /** @var User */
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
