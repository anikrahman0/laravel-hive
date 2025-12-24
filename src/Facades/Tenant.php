<?php

namespace AnikRahman\Hive\Facades;

use Illuminate\Support\Facades\Facade;

class Tenant extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'currentTenant'; // Returns the tenant from container
    }

    /**
     * Get the current tenant instance.
     */
    public static function current()
    {
        return app()->bound('currentTenant') ? app()->make('currentTenant') : null;
    }
}
