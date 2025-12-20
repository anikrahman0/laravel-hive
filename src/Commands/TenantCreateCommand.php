<?php

namespace AnikRahman\Hive\Commands;

use Illuminate\Console\Command;
use AnikRahman\Hive\Models\Tenant;

class TenantCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:create
                            {name : Tenant display name}
                            {subdomain : Subdomain for tenant}
                            {--domain= : Optional custom domain}
                            {--plan=free : Tenant plan}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new tenant';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $subdomain = strtolower($this->argument('subdomain'));
        $domain = $this->option('domain');
        $plan = $this->option('plan');

        // Check reserved subdomains
        if (in_array($subdomain, config('laravel-hive.reserved_subdomains', []))) {
            $this->error("Subdomain '{$subdomain}' is reserved. Please choose another.");
            return 1;
        }

        // Check if subdomain or domain already exists
        if (Tenant::where('subdomain', $subdomain)->exists()) {
            $this->error("Subdomain '{$subdomain}' already exists!");
            return 1;
        }

        if ($domain && Tenant::where('custom_domain', $domain)->exists()) {
            $this->error("Domain '{$domain}' already exists!");
            return 1;
        }

        // Create tenant
        $tenant = Tenant::create([
            'name' => $name,
            'subdomain' => $subdomain,
            'custom_domain' => $domain,
            'plan' => $plan,
        ]);

        $this->info("Tenant '{$name}' created successfully with subdomain '{$subdomain}'!");
        return 0;
    }
}
