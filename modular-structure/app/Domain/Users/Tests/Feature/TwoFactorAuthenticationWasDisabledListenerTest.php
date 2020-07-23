<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Events\TwoFactorAuthenticationWasDisabled;
use Preferred\Domain\Users\Listeners\TwoFactorAuthenticationWasDisabledListener;
use Tests\TestCase;

class TwoFactorAuthenticationWasDisabledListenerTest extends TestCase
{
    private TwoFactorAuthenticationWasDisabledListener $twoFactorAuthenticationWasDisabledListener;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->twoFactorAuthenticationWasDisabledListener = $this->app->make(TwoFactorAuthenticationWasDisabledListener::class);
        $this->user = factory(User::class)->create();
    }

    public function testHandle()
    {
        $oldToken = $this->user->email_token_confirmation;
        $this->twoFactorAuthenticationWasDisabledListener->handle(new TwoFactorAuthenticationWasDisabled($this->user));
        $this->user->refresh();
        $this->assertNotEquals($oldToken, $this->user->email_token_confirmation);
    }
}
