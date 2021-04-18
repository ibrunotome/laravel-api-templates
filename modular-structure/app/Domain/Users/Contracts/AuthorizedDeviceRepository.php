<?php

namespace App\Domain\Users\Contracts;

use App\Infrastructure\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface AuthorizedDeviceRepository extends BaseRepository
{
    public function doesNotHaveAuthorizedAnyDeviceYet(string $userId): bool;

    public function findDeviceByCriteria(array $data): Model|Builder|null;
}
