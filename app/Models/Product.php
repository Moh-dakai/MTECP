<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Product extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'price_cents',
        'stock',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price_cents' => 'integer',
        'stock' => 'integer',
    ];

    /**
     * Get the tenant that owns the product.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the primary category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all categories assigned to this product via pivot.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Check if product is low on stock.
     */
    public function isLowStock(int $threshold = 10): bool
    {
        return $this->stock <= $threshold;
    }
}
