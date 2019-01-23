<?php

namespace Preferred\Domain\Users\Listeners\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Preferred\Domain\Users\Entities\Permission;
use Ramsey\Uuid\Uuid;

class PermissionObserver
{
    public function creating(Model $model)
    {
        $model->id = Uuid::uuid4();
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