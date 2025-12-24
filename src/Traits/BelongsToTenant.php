<?php

namespace AnikRahman\Hive\Traits;

use Illuminate\Database\Eloquent\Builder;
use AnikRahman\Hive\Models\Tenant;

trait BelongsToTenant
{
    /**
     * Boot the trait for shared database multi-tenancy.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $builder->where('tenant_id', Tenant::getTenantId());
        });
    }
}
