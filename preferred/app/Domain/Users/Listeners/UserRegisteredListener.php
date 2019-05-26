<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Notifications\VerifyEmailNotification;
use Preferred\Infrastructure\Abstracts\AbstractListener;

class UserRegisteredListener extends AbstractListener
{
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
        /**
         * @var Profile $profile
         */
        $profile = $event->user->profile;

        Notification::send($event->user, new VerifyEmailNotification($profile->email_token_confirmation));
    }
}
