<?php

namespace App\Listeners\Observers;

use App\Models\AuthorizedDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Neves\Events\Contracts\TransactionalEvent;
use Ramsey\Uuid\Uuid;

class AuthorizedDeviceObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->id = Uuid::uuid4();

        if (auth()->check()) {
            $model->user_id = auth()->id();
        }
    }

    public function created(AuthorizedDevice $authorizedDevice)
    {
        Cache::tags('users:' . $authorizedDevice->user_id)->flush();
        Cache::tags('users')->flush();
    }

    public function deleted(AuthorizedDevice $authorizedDevice)
    {
        Cache::tags('users:' . $authorizedDevice->user_id)->flush();
        Cache::tags('users')->flush();
    }
}
