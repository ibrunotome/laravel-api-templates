<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Notifications\TwoFactorAuthenticationWasDisabledNotification;
use Preferred\Infrastructure\Abstracts\Listener;

class TwoFactorAuthenticationWasDisabledListener extends Listener
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    public function handle($event)
    {
        /**
         * @var ProfileRepository $profileRepository
         */
        $profileRepository = app(ProfileRepository::class);
        $profileRepository->setNewEmailTokenConfirmation($event->user->id);

        Notification::send($event->user, new TwoFactorAuthenticationWasDisabledNotification());
    }
}
