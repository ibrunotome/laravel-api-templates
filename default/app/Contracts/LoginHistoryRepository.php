<?php

namespace App\Contracts;

interface LoginHistoryRepository extends BaseRepository
{
    public function loginsWithThisIpExists(array $data): bool;
}
