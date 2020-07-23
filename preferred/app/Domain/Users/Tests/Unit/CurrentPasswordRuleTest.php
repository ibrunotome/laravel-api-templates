<?php

namespace Preferred\Domain\Users\Tests\Unit;

use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Rules\CurrentPasswordRule;
use Tests\TestCase;

class CurrentPasswordRuleTest extends TestCase
{
    private CurrentPasswordRule $rule;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->rule = new CurrentPasswordRule();
    }

    public function testWillPassBecausePasswordMatch()
    {
        $this->be($this->user);
        $this->assertTrue($this->rule->passes('current_password', 'secretxxx'));
    }

    public function testWillNotPassBecausePasswordNotMatch()
    {
        $this->be($this->user);
        $this->assertFalse($this->rule->passes('current_password', 'skjdfksf233ksjd'));
    }
}
