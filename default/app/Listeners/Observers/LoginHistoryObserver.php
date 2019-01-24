<?php

namespace App\Listeners\Observers;

use App\Models\LoginHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Neves\Events\Contracts\TransactionalEvent;
use Ramsey\Uuid\Uuid;

class LoginHistoryObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->id = Uuid::uuid4();

        if (auth()->check()) {
            $model->user_id = auth()->id();
        }
    }

    public function created(LoginHistory $loginHistory)
    {
        Cache::tags('users:' . $loginHistory->user_id)->flush();
        Cache::tags('users')->flush();
    }
}
