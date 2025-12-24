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
            $tenantId = Tenant::id();

            if ($tenantId !== null) {
                $builder->where('tenant_id', $tenantId);
            }
        });

        // Auto-set tenant_id when creating - THIS MUST BE OUTSIDE THE SCOPE!
        static::creating(function ($model) {
            if (empty($model->tenant_id) && $tenantId = Tenant::id()) {
                $model->tenant_id = $tenantId;
            }
        });
    }
}
