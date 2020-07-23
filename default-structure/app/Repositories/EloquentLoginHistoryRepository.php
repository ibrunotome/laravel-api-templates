<?php

namespace App\Repositories;

use App\Contracts\LoginHistoryRepository;

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
