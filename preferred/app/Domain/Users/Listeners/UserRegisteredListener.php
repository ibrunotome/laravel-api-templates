<?php

namespace Preferred\Domain\Users\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Notifications\VerifyEmailNotification;
use Preferred\Infrastructure\Abstracts\AbstractListener;
use Ramsey\Uuid\Uuid;

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
     *
     * @throws \Exception
     */
    public function handle($event)
    {
        /** @var User $user */
        $user = $event->user;

        /** @var ProfileRepository $profileRepository */
        $profileRepository = app(ProfileRepository::class);

        /** @var Profile $profile */
        $profile = $profileRepository->store([
            'email_token_confirmation'    => Uuid::uuid4(),
            'email_token_disable_account' => Uuid::uuid4(),
            'user_id'                     => $user->id,
        ]);

        Notification::send($event->user, new VerifyEmailNotification($profile->email_token_confirmation));
    }
}
