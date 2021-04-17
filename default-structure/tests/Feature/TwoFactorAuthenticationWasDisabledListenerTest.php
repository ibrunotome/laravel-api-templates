<?php

namespace Tests\Feature;

use App\Events\TwoFactorAuthenticationWasDisabled;
use App\Listeners\TwoFactorAuthenticationWasDisabledListener;
use App\Models\User;
use Tests\TestCase;

class TwoFactorAuthenticationWasDisabledListenerTest extends TestCase
{
    private TwoFactorAuthenticationWasDisabledListener $twoFactorAuthenticationWasDisabledListener;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->twoFactorAuthenticationWasDisabledListener = $this->app->make(TwoFactorAuthenticationWasDisabledListener::class);
        $this->user = User::factory()->create();
    }

    public function testHandle()
    {
        $oldToken = $this->user->email_token_confirmation;
        $this->twoFactorAuthenticationWasDisabledListener->handle(new TwoFactorAuthenticationWasDisabled($this->user));
        $this->user->refresh();
        $this->assertNotEquals($oldToken, $this->user->email_token_confirmation);
    }
}
