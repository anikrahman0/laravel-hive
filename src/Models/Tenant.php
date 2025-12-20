<?php

namespace AnikRahman\Hive\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'tenants';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'subdomain',
        'custom_domain',
        'plan',
        'status',
        'database',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'status' => 1, // active by default
    ];
}
