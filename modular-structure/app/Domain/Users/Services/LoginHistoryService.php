<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\Contracts\LoginHistoryRepository;
use App\Domain\Users\Entities\User;
use App\Domain\Users\Notifications\SuccessfulLoginFromIpNotification;
use Illuminate\Support\Facades\Notification;

class LoginHistoryService
{
    private LoginHistoryRepository $loginHistoryRepository;

    public function __construct(LoginHistoryRepository $loginHistoryRepository)
    {
        $this->loginHistoryRepository = $loginHistoryRepository;
    }

    public function store(User $user, array $data)
    {
        $this->sendNotificationIfNewIp($user, $data);
        $this->loginHistoryRepository->store($data);
    }

    private function sendNotificationIfNewIp(User $user, array $data)
    {
        $loginsWithThisIpExists = $this->loginHistoryRepository->loginsWithThisIpExists($data);

        if (!$loginsWithThisIpExists) {
            Notification::send($user, new SuccessfulLoginFromIpNotification($data));
        }
    }
}
