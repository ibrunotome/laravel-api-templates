<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    public function visualizeAllNotifications(): JsonResponse
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }

    public function visualizeNotification(string $id): JsonResponse
    {
        $user = auth()->user();

        $user->unreadNotifications()->findOrFail($id)->update(['read_at' => now()]);

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }
}
