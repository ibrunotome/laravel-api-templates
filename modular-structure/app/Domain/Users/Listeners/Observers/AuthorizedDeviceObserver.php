<?php

namespace App\Domain\Users\Listeners\Observers;

use App\Domain\Users\Entities\AuthorizedDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Neves\Events\Contracts\TransactionalEvent;
use Ramsey\Uuid\Uuid;

class AuthorizedDeviceObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->setAttribute('id', $model->getAttribute('id') ?? Uuid::uuid4()->toString());

        if (is_null($model->getAttribute('user_id')) && auth()->check()) {
            $model->setAttribute('user_id', auth()->id());
        }
    }

    public function created(AuthorizedDevice $authorizedDevice)
    {
        Cache::tags('users:' . $authorizedDevice->user_id)->flush();
    }

    public function deleted(AuthorizedDevice $authorizedDevice)
    {
        Cache::tags('users:' . $authorizedDevice->user_id)->flush();
    }
}
