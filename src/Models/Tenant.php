<?php

namespace AnikRahman\Hive\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'subdomain',
        'custom_domain',
        'plan',
        'status'
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Get current tenant instance
     */
    public static function current(): ?self
    {
        return app()->make('currentTenant');
    }

    /**
     * Get current tenant ID
     */
    public static function id(): ?int
    {
        $tenant = self::current();
        return $tenant ? $tenant->id : null;
    }

    /**
     * Check if tenant is active
     */
    public function isActive(): bool
    {
        return $this->status === 1;
    }

    /**
     * Get the tenant ID for use in traits
     */
    public static function getTenantId(): ?int
    {
        return self::id();
    }
}
