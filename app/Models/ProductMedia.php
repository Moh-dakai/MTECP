<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMedia extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'file_name',
        'file_path',
        'url',
        'mime_type',
        'size',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'size' => 'integer',
        'sort_order' => 'integer',
    ];

    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    /**
     * Get the product that owns the media.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
