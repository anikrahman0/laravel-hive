<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Tenant Database Connection
    |--------------------------------------------------------------------------
    | This connection will be used when DB-per-tenant mode is enabled.
    */
    'tenant_connection' => 'tenant',

    /*
    |--------------------------------------------------------------------------
    | Reserved Subdomains
    |--------------------------------------------------------------------------
    | Subdomains that cannot be used by tenants.
    */
    'reserved_subdomains' => [
        'www',
        'admin',
        'api',
        'mail',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Tenant Plan
    |--------------------------------------------------------------------------
    */
    'default_plan' => 'free',

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    | Define default features available for tenants. Can be overridden per tenant.
    */
    'features' => [
        'blog' => true,
        'analytics' => false,
        'ecommerce' => false,
    ],

];
