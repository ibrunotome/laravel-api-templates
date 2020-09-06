<?php

namespace App\Domain\Users\Listeners\Observers;

use App\Domain\Users\Entities\LoginHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Neves\Events\Contracts\TransactionalEvent;
use Ramsey\Uuid\Uuid;

class LoginHistoryObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->setAttribute('id', $model->getAttribute('id') ?? Uuid::uuid4()->toString());

        if (is_null($model->getAttribute('user_id')) && auth()->check()) {
            $model->setAttribute('user_id', auth()->id());
        }
    }

    public function created(LoginHistory $loginHistory)
    {
        Cache::tags('users:' . $loginHistory->user_id)->flush();
    }
}
