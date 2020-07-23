<?php

namespace App\Domain\Users\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Interfaces\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function visualizeAllNotifications()
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }

    public function visualizeNotification(string $id)
    {
        $user = auth()->user();

        $user->unreadNotifications()->findOrFail($id)->update(['read_at' => now()]);

        Cache::tags('users:' . $user->id)->flush();

        return $this->respondWithCustomData(['message' => 'OK'], Response::HTTP_OK);
    }
}
