<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\Contracts\UserRepository;
use App\Domain\Users\Notifications\AccountDisabledNotification;
use App\Infrastructure\Support\TwoFactorAuthenticator;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class DisableAccountService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($token)
    {
        $user = $this->userRepository->findOneBy(['email_token_disable_account' => $token]);

        try {
            return DB::transaction(function () use ($user) {
                $user->update(['is_active' => 0]);

                Notification::send($user, new AccountDisabledNotification());

                $this->loggoutUserIfNecessary();

                return true;
            });
        } catch (Exception $exception) {
            return [
                'error'   => true,
                'message' => __('We could not disable your account, please try again or enter in contact with the ' .
                    'support'),
            ];
        }
    }

    private function loggoutUserIfNecessary()
    {
        if (auth()->check()) {
            (new TwoFactorAuthenticator(request()))->logout();
            Cache::forget(auth()->id());
            Cache::tags('users:' . auth()->id())->flush();
            auth()->logout();
        }
    }
}
