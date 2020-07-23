<?php

namespace App\Domain\Users\Tests\Unit;

use App\Domain\Users\Rules\WeakPasswordRule;
use Tests\TestCase;

class WeakPasswordRuleTest extends TestCase
{
    private WeakPasswordRule $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new WeakPasswordRule();
    }

    public function testWillPassBecausePasswordIsNotInWeakPasswordList()
    {
        $this->assertTrue($this->rule->passes('password', 'skjdfksf233ksjd'));
    }

    public function testWillNotPassBecausePasswordIsInWeakPasswordList()
    {
        $this->assertFalse($this->rule->passes('password', 'senha123'));
    }
}
