<?php

namespace Preferred\Domain\Audits\Listeners\Observers;

use Illuminate\Database\Eloquent\Model;
use Neves\Events\Contracts\TransactionalEvent;
use Ramsey\Uuid\Uuid;

class AuditObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->id = Uuid::uuid4();
    }
}
