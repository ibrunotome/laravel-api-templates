<?php

namespace App\Domain\Notifications\Tests\Unit;

use App\Infrastructure\Support\ExceptionFormat;
use Exception;
use Tests\TestCase;

class ExceptionFromatTest extends TestCase
{
    public function testLog()
    {
        $exception = new Exception('testing');

        $message = ExceptionFormat::log($exception);

        $this->assertStringStartsWith('File:', $message);
    }
}
