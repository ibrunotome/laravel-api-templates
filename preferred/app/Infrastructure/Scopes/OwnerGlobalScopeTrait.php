<?php

namespace Preferred\Infrastructure\Scopes;

trait OwnerGlobalScopeTrait
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OwnerScope());
    }
}