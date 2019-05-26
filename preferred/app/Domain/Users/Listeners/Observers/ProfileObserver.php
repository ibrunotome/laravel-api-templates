<?php

namespace Preferred\Domain\Users\Listeners\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Neves\Events\Contracts\TransactionalEvent;
use Preferred\Domain\Users\Entities\Profile;
use Ramsey\Uuid\Uuid;

class ProfileObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->id = Uuid::uuid4();

        if (auth()->check()) {
            $model->user_id = auth()->id();
        }
    }

    public function updated(Profile $profile)
    {
        $this->created($profile);
    }

    public function created(Profile $profile)
    {
        Cache::put($profile->id, $profile, 3600);
        Cache::tags('users:' . $profile->user_id)->flush();
        Cache::tags('profiles')->flush();
    }
}
