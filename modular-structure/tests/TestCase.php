<?php

namespace Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use App\Application\Exceptions\Handler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use AttachJwtToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->setLocale('en_US');

        Queue::fake();
        Notification::fake();
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
