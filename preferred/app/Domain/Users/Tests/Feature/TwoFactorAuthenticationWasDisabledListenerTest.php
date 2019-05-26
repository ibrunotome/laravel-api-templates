<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Events\TwoFactorAuthenticationWasDisabled;
use Preferred\Domain\Users\Listeners\TwoFactorAuthenticationWasDisabledListener;
use Tests\TestCase;

class TwoFactorAuthenticationWasDisabledListenerTest extends TestCase
{
    /**
     * @var TwoFactorAuthenticationWasDisabledListener
     */
    private $twoFactorAuthenticationWasDisabledListener;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Profile
     */
    private $profile;

    public function setUp(): void
    {
        parent::setUp();

        $this->twoFactorAuthenticationWasDisabledListener = $this->app->make(TwoFactorAuthenticationWasDisabledListener::class);
        $this->user = factory(User::class)->create();
        $this->profile = factory(Profile::class)->create(['user_id' => $this->user->id]);
    }

    public function testHandle()
    {
        $oldToken = $this->profile->email_token_confirmation;
        $this->twoFactorAuthenticationWasDisabledListener->handle(new TwoFactorAuthenticationWasDisabled($this->user));
        $this->profile->refresh();
        $this->assertNotEquals($oldToken, $this->profile->email_token_confirmation);
    }
}
