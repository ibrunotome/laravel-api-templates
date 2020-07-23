<?php

namespace Preferred\Domain\Users\Contracts;

use Preferred\Infrastructure\Contracts\BaseRepository;

interface LoginHistoryRepository extends BaseRepository
{
    public function loginsWithThisIpExists(array $data): bool;
}
