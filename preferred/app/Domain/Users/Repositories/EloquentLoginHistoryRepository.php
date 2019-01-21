<?php

namespace Preferred\Domain\Users\Repositories;

use Preferred\Domain\Users\Contracts\LoginHistoryRepository;
use Preferred\Infrastructure\Abstracts\AbstractEloquentRepository;

class EloquentLoginHistoryRepository extends AbstractEloquentRepository implements LoginHistoryRepository
{
    public function loginsWithThisIpExists(array $data): bool
    {
        return $this->model->with([])
            ->where('user_id', '=', $data['user_id'])
            ->where('ip', '=', $data['ip'])
            ->exists();
    }
}
