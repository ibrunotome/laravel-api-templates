<?php

namespace App\Http\Controllers;

use App\Http\ResponseTrait;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ResponseTrait;
}
