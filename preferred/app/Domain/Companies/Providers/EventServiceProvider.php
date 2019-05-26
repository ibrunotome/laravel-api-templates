<?php

namespace Preferred\Domain\Companies\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Neves\Events\Contracts\TransactionalEvent;
use Preferred\Domain\Companies\Entities\Company;
use Preferred\Domain\Companies\Listeners\Observers\CompanyObserver;

class EventServiceProvider extends ServiceProvider implements TransactionalEvent
{
    protected $listen = [];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        Company::observe(CompanyObserver::class);
    }
}
