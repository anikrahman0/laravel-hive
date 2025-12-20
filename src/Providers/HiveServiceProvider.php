<?php

namespace AnikRahman\Hive\Providers;

use Illuminate\Support\ServiceProvider;
use AnikRahman\Hive\Middleware\HiveTenantMiddleware;
use AnikRahman\Hive\Commands\TenantCreateCommand;
use AnikRahman\Hive\Commands\TenantStatusCommand;
use AnikRahman\Hive\Commands\TenantMigrateCommand;

class HiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge package config
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laravel-hive.php',
            'laravel-hive'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/laravel-hive.php' => config_path('laravel-hive.php'),
        ], 'hive-config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => database_path('migrations'),
        ], 'hive-migrations');

        // Register middleware alias
        $this->app['router']->aliasMiddleware(
            'hive.tenant',
            HiveTenantMiddleware::class
        );

        // Register CLI commands (console only)
        if ($this->app->runningInConsole()) {
            $this->commands([
                TenantCreateCommand::class,
                TenantStatusCommand::class,
                TenantMigrateCommand::class,
            ]);
        }
    }
}
