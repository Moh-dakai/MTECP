<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'email',
        'name',
        'is_subscribed',
        'unsubscribed_at',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the subscriber.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
