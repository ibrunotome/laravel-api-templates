<?php

namespace App\Listeners\Observers;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class RoleObserver
{
    public function creating(Model $model)
    {
        $model->setAttribute('id', $model->getAttribute('id') ?? Uuid::uuid4()->toString());
        $model->guard_name = 'api';
    }

    public function updated(Role $role)
    {
        $this->created($role);
    }

    public function created(Role $role)
    {
        Cache::forget('spatie.permission.cache');
    }
}
