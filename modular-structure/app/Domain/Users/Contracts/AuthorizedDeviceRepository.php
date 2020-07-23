<?php

namespace Preferred\Domain\Users\Contracts;

use Preferred\Infrastructure\Contracts\BaseRepository;

interface AuthorizedDeviceRepository extends BaseRepository
{
    public function doesNotHaveAuthorizedAnyDeviceYet(string $userId): bool;

    public function findDeviceByCriteria(array $data);
}
