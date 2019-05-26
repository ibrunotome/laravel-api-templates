<?php

namespace App\Contracts;

interface AuthorizedDeviceRepository extends BaseRepository
{
    public function doesNotHaveAuthorizedAnyDeviceYet(string $userId): bool;

    public function findDeviceByCriteria(array $data);
}
