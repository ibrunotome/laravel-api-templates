<?php

namespace Tests\Feature;

use App\Listeners\PasswordResetListener;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Tests\TestCase;

class PasswordResetListenerTest extends TestCase
{
    /** @var PasswordResetListener */
    private $passwordResetListener;

    /** @var User */
    private $user;

    /** @var Profile */
    private $profile;

    public function setUp()
    {
        parent::setUp();

        $this->passwordResetListener = $this->app->make(PasswordResetListener::class);
        $this->user = factory(User::class)->create();
        $this->profile = factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testHandle()
    {
        $oldToken = $this->profile->email_token_confirmation;
        $this->passwordResetListener->handle(new PasswordReset($this->user));
        $this->profile->refresh();
        $this->assertNotEquals($oldToken, $this->profile->email_token_confirmation);
    }
}
