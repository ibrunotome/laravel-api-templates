<?php

namespace App\Domain\Users\Tests\Unit;

use App\Domain\Users\Rules\CnpjRule;
use Tests\TestCase;

class CnpjRuleTest extends TestCase
{
    private CnpjRule $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new CnpjRule();
    }

    public function testValidCnpj()
    {
        $this->assertTrue($this->rule->passes('cnpj', '27.558.514/0001-13'));
        $this->assertTrue($this->rule->passes('cnpj', '27558514000113'));
    }

    public function testInValidCnpj()
    {
        $this->assertFalse($this->rule->passes('cnpj', '27.558.514/0001-12'));
        $this->assertFalse($this->rule->passes('cnpj', '27558514000112'));
        $this->assertFalse($this->rule->passes('cnpj', '127.489.080-23'));
        $this->assertFalse($this->rule->passes('cnpj', '12748908023'));
    }
}
