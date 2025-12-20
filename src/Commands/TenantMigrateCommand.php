<?php

namespace AnikRahman\Hive\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use AnikRahman\Hive\Models\Tenant;

class TenantMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:migrate
                            {subdomain : Tenant subdomain}
                            {--fresh : Drop all tables and re-run migrations}';

    /**
     * The console command description.
     */
    protected $description = 'Run migrations for a specific tenant database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $subdomain = strtolower($this->argument('subdomain'));
        $fresh = $this->option('fresh');

        $tenant = Tenant::where('subdomain', $subdomain)->first();

        if (! $tenant) {
            $this->error("Tenant '{$subdomain}' not found.");
            return 1;
        }

        if (! $tenant->database) {
            $this->error("Tenant '{$subdomain}' does not have a database configured.");
            return 1;
        }

        // Switch DB connection dynamically
        Config::set('database.connections.tenant.database', $tenant->database);
        Config::set('database.default', config('laravel-hive.tenant_connection'));

        // Run migrations
        $command = $fresh ? 'migrate:fresh' : 'migrate';

        Artisan::call($command, [
            '--database' => config('laravel-hive.tenant_connection'),
            '--force' => true,
        ]);

        $this->info("Migrations completed for tenant '{$tenant->name}'.");
        return 0;
    }
}
