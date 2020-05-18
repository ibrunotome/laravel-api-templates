<?php

namespace App\Listeners\Observers;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Neves\Events\Contracts\TransactionalEvent;
use Ramsey\Uuid\Uuid;

class CompanyObserver implements TransactionalEvent
{
    public function creating(Model $model)
    {
        $model->setAttribute('id', $model->getAttribute('id') ?? Uuid::uuid4()->toString());
    }

    public function updated(Company $company)
    {
        Cache::put($company->id, $company, 60);
        Cache::tags('companies')->flush();
    }
}
