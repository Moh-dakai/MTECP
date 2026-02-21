<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Tax extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'rate',
        'country',
        'state',
        'zip',
        'is_active',
        'is_compound',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_compound' => 'boolean',
        'rate' => 'decimal:2',
    ];

    /**
     * Get the tenant that owns the tax.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
