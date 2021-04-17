<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UtilController extends Controller
{
    public function serverTime(): JsonResponse
    {
        $now = now();
        $milliseconds = substr((string)$now->micro, 0, 3);
        $response = $now->format('Y-m-d\TH:i:s') . '.' . $milliseconds . 'Z';

        return $this->respondWithCustomData(['message' => $response], Response::HTTP_OK);
    }
}
