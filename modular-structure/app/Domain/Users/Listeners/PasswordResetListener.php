<?php

namespace App\Domain\Users\Listeners;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Notifications\PasswordChangedNotification;
use App\Infrastructure\Abstracts\Listener;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Notification;

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
