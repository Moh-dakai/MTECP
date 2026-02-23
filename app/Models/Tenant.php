<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant
{
    use HasDomains;

    // We do NOT use HasDatabase here because we are implementing single-database multi-tenancy.
    
    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'color_primary',
        'color_secondary',
    ];

    /**
     * Get a tenant attribute from the data JSON column.
     */
    public function __get($key)
    {
        // Check if it's a known attribute that should come from data
        if (in_array($key, ['name', 'color_primary', 'color_secondary'])) {
            return $this->data[$key] ?? null;
        }
        
        return parent::__get($key);
    }

    /**
     * Set a tenant attribute, storing it in the data JSON column.
     */
    public function __set($key, $value)
    {
        // Check if it's a known attribute that should be stored in data
        if (in_array($key, ['name', 'color_primary', 'color_secondary'])) {
            $data = $this->data ?? [];
            $data[$key] = $value;
            $this->data = $data;
            return;
        }
        
        parent::__set($key, $value);
    }

    /**
     * Check if a tenant attribute exists in the data JSON column.
     */
    public function __isset($key)
    {
        if (in_array($key, ['name', 'color_primary', 'color_secondary'])) {
            return isset($this->data[$key]);
        }
        
        return parent::__isset($key);
    }
}
