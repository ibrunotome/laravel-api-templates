<?php

namespace App\Repositories;

use App\Contracts\AuthorizedDeviceRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentAuthorizedDevicesRepository extends EloquentRepository implements AuthorizedDeviceRepository
{
    public function doesNotHaveAuthorizedAnyDeviceYet(string $userId): bool
    {
        return $this->model::query()->where('user_id', '=', $userId)->count('id') === 0;
    }

    public function findDeviceByCriteria(array $data): Model|Builder|null
    {
        return $this->model::query()
            ->where('user_id', '=', $data['user_id'])
            ->where('device', '=', $data['device'])
            ->where('platform', '=', $data['platform'])
            ->where('platform_version', '=', $data['platform_version'])
            ->where('browser', '=', $data['browser'])
            ->where('browser_version', '=', $data['browser_version'])
            ->where('city', '=', $data['city'])
            ->first();
    }
}
