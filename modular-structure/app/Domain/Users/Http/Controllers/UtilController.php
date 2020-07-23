<?php

namespace Preferred\Domain\Users\Http\Controllers;

use Illuminate\Http\Response;
use Preferred\Interfaces\Http\Controllers\Controller;

class UtilController extends Controller
{
    public function serverTime()
    {
        $now = now();
        $milliseconds = substr((string)$now->micro, 0, 3);
        $response = $now->format('Y-m-d\TH:i:s') . '.' . $milliseconds . 'Z';

        return $this->respondWithCustomData(['message' => $response], Response::HTTP_OK);
    }
}
