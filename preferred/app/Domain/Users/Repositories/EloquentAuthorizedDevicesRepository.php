<?php

namespace Preferred\Domain\Users\Repositories;

use Preferred\Domain\Users\Contracts\AuthorizedDeviceRepository;
use Preferred\Infrastructure\Abstracts\AbstractEloquentRepository;

class EloquentAuthorizedDevicesRepository extends AbstractEloquentRepository implements AuthorizedDeviceRepository
{
    public function doesNotHaveAuthorizedDevice(string $userId): bool
    {
        return $this->model::query()->where('user_id', '=', $userId)->count(['id']) === 0;
    }

    public function deviceExists(array $data)
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
