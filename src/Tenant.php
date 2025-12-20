<?php

namespace AnikRahman\Hive;

use AnikRahman\Hive\Models\Tenant as TenantModel;

class Tenant
{
    /**
     * Get the current tenant model instance
     *
     * @return TenantModel|null
     */
    public static function current(): ?TenantModel
    {
        return app()->make('currentTenant');
    }

    /**
     * Get current tenant ID
     *
     * @return int|null
     */
    public static function id(): ?int
    {
        $tenant = self::current();
        return $tenant ? $tenant->id : null;
    }

    /**
     * Get current tenant plan
     *
     * @return string|null
     */
    public static function plan(): ?string
    {
        $tenant = self::current();
        return $tenant ? $tenant->plan : null;
    }

    /**
     * Check if a feature is enabled for the tenant
     *
     * @param string $feature
     * @return bool
     */
    public static function feature(string $feature): bool
    {
        $tenant = self::current();
        $features = config('laravel-hive.features', []);
        return $tenant && isset($features[$feature]) ? $features[$feature] : false;
    }
}
