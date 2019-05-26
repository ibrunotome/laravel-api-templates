<?php

namespace Preferred\Domain\Users\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\ProfileRepository;
use Preferred\Domain\Users\Entities\Profile;
use Preferred\Domain\Users\Notifications\AccountDisabledNotification;
use Preferred\Infrastructure\Support\TwoFactorAuthenticator;

class DisableAccountService
{
    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function handle($token)
    {
        /**
         * @var Profile $profile
         */
        $profile = $this->profileRepository
            ->with(['user'])
            ->findOneBy(['email_token_disable_account' => $token]);

        try {
            return DB::transaction(function () use ($profile) {
                $profile->user->update(['is_active' => 0]);

                Notification::send($profile->user, new AccountDisabledNotification());

                $this->loggoutUserIfNecessary();

                return true;
            });
        } catch (\Exception $exception) {
            return [
                'error'   => true,
                'message' => __('We could not disable your account, please try again or enter in contact with the support'),
            ];
        }
    }

    private function loggoutUserIfNecessary()
    {
        if (auth()->check()) {
            (new TwoFactorAuthenticator(request()))->logout();
            Cache::forget(auth()->id());
            Cache::tags('users:' . auth()->id());
            auth()->logout();
        }
    }
}
