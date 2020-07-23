<?php

namespace App\Domain\Users\Contracts;

use App\Infrastructure\Contracts\BaseRepository;

interface LoginHistoryRepository extends BaseRepository
{
    public function loginsWithThisIpExists(array $data): bool;
}
