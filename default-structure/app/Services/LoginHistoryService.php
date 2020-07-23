<?php

namespace App\Services;

use App\Contracts\LoginHistoryRepository;
use App\Models\User;
use App\Notifications\SuccessfulLoginFromIpNotification;
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
