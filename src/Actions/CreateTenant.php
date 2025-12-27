<?php

// src/Actions/CreateTenant.php
namespace AnikRahman\Hive\Actions;

use Illuminate\Support\Str;
use AnikRahman\Hive\Models\Tenant;
use Illuminate\Validation\ValidationException;

class CreateTenant
{
    public function execute(string $name, ?string $subdomain = null): Tenant
    {
        $subdomain = $subdomain
            ? $this->validateCustom($subdomain)
            : $this->generate($name);

        return Tenant::create([
            'subdomain' => $subdomain,
            'name' => $name,
            'plan' => 'free',
            'status' => 1,
        ]);
    }

    protected function generate(string $name): string
    {
        $subdomain = Str::slug($name);

        if (Tenant::where('subdomain', $subdomain)->exists()) {
            $counter = 1;
            $original = $subdomain;

            while (Tenant::where('subdomain', $subdomain)->exists()) {
                $subdomain = $original . '-' . $counter;
                $counter++; 
            }
        }

        return $subdomain;
    }

    protected function validateCustom(string $subdomain): string
    {
        $subdomain = Str::slug($subdomain, '', 'en');

        // Validation logic...

        return $subdomain;
    }
}