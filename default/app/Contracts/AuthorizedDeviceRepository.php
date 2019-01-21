<?php

namespace App\Contracts;

interface AuthorizedDeviceRepository extends BaseRepository
{
    public function doesNotHaveAuthorizedDevice(string $userId): bool;

    public function deviceExists(array $data);
}
