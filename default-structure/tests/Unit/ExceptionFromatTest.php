<?php

namespace Tests\Unit;

use App\Support\ExceptionFormat;
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
