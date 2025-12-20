<?php

namespace AnikRahman\Hive\Traits;

use Illuminate\Database\Eloquent\Builder;
use AnikRahman\Hive\Tenant;

trait BelongsToTenant
{
    /**
     * Automatically scope queries by tenant.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantId = Tenant::id();

            if ($tenantId) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenantId);
            }
        });

        static::creating(function ($model) {
            if (Tenant::id() && empty($model->tenant_id)) {
                $model->tenant_id = Tenant::id();
            }
        });
    }
}
