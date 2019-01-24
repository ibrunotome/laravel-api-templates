<?php

namespace Preferred\Infrastructure\Scopes;

trait ActiveGlobalScopeTrait
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope());
    }
}
