<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Tenant Connection
    |--------------------------------------------------------------------------
    | This connection will be used when database_per_tenant architecture is enabled.
    | Connection template defined in config/database.php
    */
    'tenant_connection' => env('TENANT_CONNECTION', 'tenant'),

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
    'default_plan' => env('TENANT_DEFAULT_PLAN', 'free'),

];
