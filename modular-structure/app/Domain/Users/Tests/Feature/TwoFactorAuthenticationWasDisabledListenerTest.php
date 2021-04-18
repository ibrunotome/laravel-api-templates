<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use App\Domain\Users\Events\TwoFactorAuthenticationWasDisabled;
use App\Domain\Users\Listeners\TwoFactorAuthenticationWasDisabledListener;
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
