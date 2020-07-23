<?php

namespace App\Infrastructure\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Listener implements ShouldQueue
{
    use Queueable;
}
