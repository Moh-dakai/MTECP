<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRate extends Model
{
    protected $fillable = [
        'shipping_zone_id',
        'name',
        'type',
        'cost',
        'free_shipping_min_amount',
        'estimated_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cost' => 'decimal:2',
        'free_shipping_min_amount' => 'decimal:2',
    ];

    const TYPE_FLAT_RATE = 'flat_rate';
    const TYPE_FREE_SHIPPING = 'free_shipping';
    const TYPE_LOCAL_PICKUP = 'local_pickup';

    /**
     * Get the shipping zone that owns the rate.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }
}
