<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Contracts\LoginHistoryRepository;
use App\Infrastructure\Abstracts\EloquentRepository;

class EloquentLoginHistoryRepository extends EloquentRepository implements LoginHistoryRepository
{
    public function loginsWithThisIpExists(array $data): bool
    {
        return $this->model->query()
            ->where('user_id', '=', $data['user_id'])
            ->where('ip', '=', $data['ip'])
            ->exists();
    }
}
