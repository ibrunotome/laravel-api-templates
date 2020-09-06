<?php

namespace App\Domain\Users\Listeners\Observers;

use App\Domain\Users\Entities\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class PermissionObserver
{
    public function creating(Model $model)
    {
        $model->setAttribute('id', $model->getAttribute('id') ?? Uuid::uuid4()->toString());
        $model->guard_name = 'api';
    }

    public function updated(Permission $permission)
    {
        $this->created($permission);
    }

    public function created(Permission $permission)
    {
        Cache::forget('spatie.permission.cache');
    }
}
