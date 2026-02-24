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
        'data',
    ];

    /**
     * Get the tenant name from data JSON.
     */
    public function getNameAttribute(): ?string
    {
        $data = $this->getAttribute('data');
        return is_array($data) ? ($data['name'] ?? null) : null;
    }

    /**
     * Get the primary color from data JSON.
     */
    public function getColorPrimaryAttribute(): ?string
    {
        $data = $this->getAttribute('data');
        return is_array($data) ? ($data['color_primary'] ?? null) : null;
    }

    /**
     * Get the secondary color from data JSON.
     */
    public function getColorSecondaryAttribute(): ?string
    {
        $data = $this->getAttribute('data');
        return is_array($data) ? ($data['color_secondary'] ?? null) : null;
    }

    /**
     * Set the tenant name in data JSON.
     */
    public function setNameAttribute(?string $value): void
    {
        $data = $this->getAttribute('data') ?? [];
        $data['name'] = $value;
        $this->setAttribute('data', $data);
    }

    /**
     * Set the primary color in data JSON.
     */
    public function setColorPrimaryAttribute(?string $value): void
    {
        $data = $this->getAttribute('data') ?? [];
        $data['color_primary'] = $value;
        $this->setAttribute('data', $data);
    }

    /**
     * Set the secondary color in data JSON.
     */
    public function setColorSecondaryAttribute(?string $value): void
    {
        $data = $this->getAttribute('data') ?? [];
        $data['color_secondary'] = $value;
        $this->setAttribute('data', $data);
    }
}
