<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Notifications\TwoFactorAuthenticationWasDisabledNotification;
use Preferred\Infrastructure\Abstracts\AbstractListener;

class TwoFactorAuthenticationWasDisabledListener extends AbstractListener
{
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
