<?php

namespace Preferred\Domain\Users\Services;

use Illuminate\Support\Facades\Notification;
use Preferred\Domain\Users\Contracts\LoginHistoryRepository;
use Preferred\Domain\Users\Entities\User;
use Preferred\Domain\Users\Notifications\SuccessfulLoginFromIpNotification;

class LoginHistoryService
{
    /** @var LoginHistoryRepository */
    private $loginHistoryRepository;

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