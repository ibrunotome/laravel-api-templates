<?php

namespace App\Listeners;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class UserRegisteredListener implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     * @throws \Exception
     */
    public function handle($event)
    {
        Notification::send($event->user, new VerifyEmailNotification($event->user->email_token_confirmation));
    }
}
