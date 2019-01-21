<?php

namespace Preferred\Domain\Notifications\Tests\Unit;

use Preferred\Infrastructure\Support\ExceptionFormat;
use Tests\TestCase;

class ExceptionFromatTest extends TestCase
{
    public function testLog()
    {
        $exception = new \Exception('testing');

        $message = ExceptionFormat::log($exception);

        $this->assertStringStartsWith('File:', $message);
    }
}
