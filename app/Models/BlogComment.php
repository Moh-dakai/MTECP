<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    protected $fillable = [
        'post_id',
        'parent_id',
        'name',
        'email',
        'comment',
        'is_approved',
        'is_spam',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_spam' => 'boolean',
    ];

    /**
     * Get the blog post that owns the comment.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }

    /**
     * Get the parent comment.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    /**
     * Get the replies.
     */
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }
}
