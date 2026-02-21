<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const LOCATION_HEADER = 'header';
    const LOCATION_FOOTER = 'footer';
    const LOCATION_MOBILE = 'mobile';

    /**
     * Get the tenant that owns the menu.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the menu items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
