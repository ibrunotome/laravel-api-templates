<?php

namespace Tests\Feature;

use App\Listeners\PasswordResetListener;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Tests\TestCase;

class PasswordResetListenerTest extends TestCase
{
    /**
     * @var PasswordResetListener
     */
    private $passwordResetListener;

    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->passwordResetListener = $this->app->make(PasswordResetListener::class);
        $this->user = factory(User::class)->create();
    }

    public function testHandle()
    {
        $oldToken = $this->user->email_token_confirmation;
        $this->passwordResetListener->handle(new PasswordReset($this->user));
        $this->user->refresh();
        $this->assertNotEquals($oldToken, $this->user->email_token_confirmation);
    }
}
