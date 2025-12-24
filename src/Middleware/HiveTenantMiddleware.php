<?php

namespace AnikRahman\Hive\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use AnikRahman\Hive\Models\Tenant;

class HiveTenantMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Resolve tenant from request
        $tenant = $this->resolveTenant($request);

        // No tenant found → continue (public routes)
        if (! $tenant) {
            app()->instance('currentTenant', null);
            return $next($request);
        }

        // Check if tenant is active
        if (! $tenant->isActive()) {
            abort(403, 'Tenant account is suspended or inactive.');
        }

        // Bind tenant globally
        app()->instance('currentTenant', $tenant);

        return $next($request);
    }

    /**
     * Resolve tenant from subdomain or custom domain.
     */
    protected function resolveTenant(Request $request): ?Tenant
    {
        $host = $request->getHost();
        $segments = explode('.', $host);

        if (count($segments) > 2) {
            $subdomain = $segments[0];

            // Get reserved subdomains from config
            $reserved = config('laravel-hive.reserved_subdomains', []);
            if (in_array($subdomain, $reserved)) {
                return null;
            }

            $tenant = Tenant::where('subdomain', $subdomain)->first();
            if ($tenant) {
                return $tenant;
            }
        }

        // Check custom domain
        return Tenant::where('custom_domain', $host)->first();
    }
}
