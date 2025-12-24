<?php

namespace AnikRahman\Hive\Providers;

use Illuminate\Support\ServiceProvider;
use AnikRahman\Hive\Commands\TenantsListCommand;
use AnikRahman\Hive\Commands\TenantCreateCommand;
use AnikRahman\Hive\Commands\TenantStatusCommand;
use AnikRahman\Hive\Commands\TenantMigrateCommand;
use AnikRahman\Hive\Middleware\HiveTenantMiddleware;

class HiveServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laravel-hive.php',
            'laravel-hive'
        );

    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../../config/laravel-hive.php' => config_path('laravel-hive.php'),
        ], 'hive-config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations'),
        ], 'hive-migrations');

        // Register middleware
        $this->app['router']->aliasMiddleware('hive.tenant', HiveTenantMiddleware::class);


        // Register CLI commands (console only)
        if ($this->app->runningInConsole()) {
            $this->commands([
                TenantsListCommand::class,
                TenantCreateCommand::class,
                TenantStatusCommand::class,
                TenantMigrateCommand::class,
            ]);
        }
    }
}
