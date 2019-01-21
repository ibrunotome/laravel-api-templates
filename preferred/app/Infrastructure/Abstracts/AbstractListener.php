<?php

namespace Preferred\Infrastructure\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class AbstractListener implements ShouldQueue
{
    use Queueable;
}
