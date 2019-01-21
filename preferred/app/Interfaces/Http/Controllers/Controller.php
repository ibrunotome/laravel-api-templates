<?php

namespace Preferred\Interfaces\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ResponseTrait;
}
