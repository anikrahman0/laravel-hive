<?php

namespace AnikRahman\Hive\Commands;

use Illuminate\Console\Command;
use AnikRahman\Hive\Models\Tenant;

class TenantStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:status
                            {subdomain : Tenant subdomain}
                            {status : active|inactive}';

    /**
     * The console command description.
     */
    protected $description = 'Activate or suspend a tenant';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $subdomain = strtolower($this->argument('subdomain'));
        $statusInput = strtolower($this->argument('status'));

        $tenant = Tenant::where('subdomain', $subdomain)->first();

        if (! $tenant) {
            $this->error("Tenant with subdomain '{$subdomain}' not found.");
            return 1;
        }

        if (! in_array($statusInput, ['active', 'inactive'])) {
            $this->error("Status must be either 'active' or 'inactive'.");
            return 1;
        }

        $tenant->status = $statusInput === 'active' ? 1 : 0;
        $tenant->save();

        $this->info("Tenant '{$tenant->name}' is now {$statusInput}.");
        return 0;
    }
}
