<?php

namespace Tests;

use Tests\TestCase;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        // Set DB before parent setup
        $this->app['config']->set('database.default', 'testbench');
        $this->app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        parent::setUp();

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Optional: run migrations manually
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }
    protected function getPackageProviders($app)
    {
        return [
            \AnikRahman\Hive\Providers\HiveServiceProvider::class,
        ];
    }
