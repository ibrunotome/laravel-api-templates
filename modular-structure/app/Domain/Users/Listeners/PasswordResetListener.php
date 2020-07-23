<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\UserRepository;
use Preferred\Domain\Users\Notifications\PasswordChangedNotification;
use Preferred\Infrastructure\Abstracts\Listener;

class PasswordResetListener extends Listener
{
    use Queueable;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->onQueue('notifications');
    }

    public function handle($event)
    {
        $this->userRepository->setNewEmailTokenConfirmation($event->user->id);

        Notification::send($event->user, new PasswordChangedNotification());
    }
}
