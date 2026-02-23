<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ShippingZone extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'countries',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'countries' => 'array',
    ];

    /**
     * Get the tenant that owns the shipping zone.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the shipping rates for the zone.
     */
    public function rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }
}
