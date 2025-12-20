<?php

namespace AnikRahman\Hive\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use AnikRahman\Hive\Models\Tenant;

class HiveTenantMiddleware
{
    /**
     * Resolve tenant from subdomain or custom domain
     * and block inactive tenants.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();              // acme.example.com
        $segments = explode('.', $host);
        $subdomain = $segments[0];

        $tenant = Tenant::where('subdomain', $subdomain)
            ->orWhere('custom_domain', $host)
            ->first();

        // No tenant found → let app decide (landing page, 404, etc.)
        if (! $tenant) {
            app()->instance('currentTenant', null);
            return $next($request);
        }

        // 🚫 Block suspended tenants
        if ((int) $tenant->status === 0) {
            abort(403, 'Tenant account is suspended.');
        }

        // Bind tenant globally
        app()->instance('currentTenant', $tenant);

        // Optional: DB-per-tenant switching
        if ($tenant->database) {
            Config::set('database.connections.tenant.database', $tenant->database);
            \DB::setDefaultConnection('tenant');
        }

        return $next($request);
    }
}
