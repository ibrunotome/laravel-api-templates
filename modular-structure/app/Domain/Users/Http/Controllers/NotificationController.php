<?php

namespace App\Domain\Users\Http\Controllers;

use App\Interfaces\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    public function visualizeAllNotifications(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->unreadNotifications->markAsRead();

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }

    public function visualizeNotification(Request $request, string $id): JsonResponse
    {
        $user = $request->user();

        $user->unreadNotifications()->findOrFail($id)->update(['read_at' => now()]);

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }
}
