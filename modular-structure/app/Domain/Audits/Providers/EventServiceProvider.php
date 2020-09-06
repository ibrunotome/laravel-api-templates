<?php

namespace App\Domain\Audits\Providers;

use App\Domain\Audits\Entities\Audit;
use App\Domain\Audits\Listeners\Observers\AuditObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Neves\Events\Contracts\TransactionalEvent;

class EventServiceProvider extends ServiceProvider implements TransactionalEvent
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Audit::observe(AuditObserver::class);
    }
}
