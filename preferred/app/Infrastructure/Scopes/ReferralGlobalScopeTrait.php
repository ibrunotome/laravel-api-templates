<?php

namespace Preferred\Infrastructure\Scopes;

trait ReferralGlobalScopeTrait
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ReferralScope());
    }
}