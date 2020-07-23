<?php

namespace App\Domain\Notifications\Tests\Unit;

use Exception;
use App\Infrastructure\Support\ExceptionFormat;
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
