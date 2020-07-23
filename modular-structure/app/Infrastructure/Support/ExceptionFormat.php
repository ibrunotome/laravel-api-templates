<?php

namespace App\Infrastructure\Support;

use Exception;

final class ExceptionFormat
{
    public static function log(Exception $exception)
    {
        $message = 'File:' . $exception->getFile() . PHP_EOL;
        $message .= 'Line:' . $exception->getLine() . PHP_EOL;
        $message .= 'Message:' . $exception->getMessage() . PHP_EOL;
        $message .= 'Stacktrace:' . PHP_EOL;
        $message .= $exception->getTraceAsString();

        return $message;
    }
}
