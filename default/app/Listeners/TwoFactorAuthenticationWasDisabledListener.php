<?php

namespace App\Listeners;

use App\Contracts\ProfileRepository;
use App\Notifications\TwoFactorAuthenticationWasDisabledNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class TwoFactorAuthenticationWasDisabledListener implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    public function handle($event)
    {
        /** @var ProfileRepository $profileRepository */
        $profileRepository = app(ProfileRepository::class);
        $profileRepository->setNewEmailTokenConfirmation($event->user->id);

        Notification::send($event->user, new TwoFactorAuthenticationWasDisabledNotification());
    }
}
