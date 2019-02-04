<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Notifications\PasswordChangedNotification;
use Preferred\Infrastructure\Abstracts\AbstractListener;

class PasswordResetListener extends AbstractListener
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

        Notification::send($event->user, new PasswordChangedNotification());
    }
}
