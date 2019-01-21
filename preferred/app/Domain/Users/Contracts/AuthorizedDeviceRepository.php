<?php

namespace Preferred\Domain\Users\Contracts;

use Preferred\Infrastructure\Contracts\BaseRepository;

interface AuthorizedDeviceRepository extends BaseRepository
{
    public function doesNotHaveAuthorizedDevice(string $userId): bool;

    public function deviceExists(array $data);
}
