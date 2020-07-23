<?php

namespace App\Domain\Users\Contracts;

use App\Infrastructure\Contracts\BaseRepository;

interface AuthorizedDeviceRepository extends BaseRepository
{
    public function doesNotHaveAuthorizedAnyDeviceYet(string $userId): bool;

    public function findDeviceByCriteria(array $data);
}
