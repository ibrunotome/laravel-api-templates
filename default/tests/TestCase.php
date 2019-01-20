<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->app->setLocale('en');
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct()
            {
            }

            public function report(\Exception $exception)
            {
            }

            public function render($request, \Exception $exception)
            {
                throw $exception;
            }
        });
    }
}
