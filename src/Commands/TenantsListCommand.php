<?php



namespace AnikRahman\Hive\Commands;


use Illuminate\Console\Command;
use AnikRahman\Hive\Models\Tenant;

class TenantsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered tenants from Laravel Hive';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch all tenants with selected columns
        $tenants = Tenant::select('id', 'name', 'subdomain', 'plan', 'status', 'database')
            ->orderBy('id', 'asc')
            ->get();

        // Check if any tenants exist
        if ($tenants->isEmpty()) {
            $this->info('No tenants found in the system.');
            return 0;
        }

        // Display formatted table with headers
        $this->table(
            ['ID', 'Name', 'Subdomain', 'Plan', 'Status', 'Database'],
            $tenants->toArray()
        );

        // Optional: Display summary statistics
        $activeCount = $tenants->where('status', 1)->count();
        $inactiveCount = $tenants->where('status', 0)->count();

        $this->newLine();
        $this->info("Total Tenants: {$tenants->count()} | Active: {$activeCount} | Inactive: {$inactiveCount}");

        return 0;
    }
}