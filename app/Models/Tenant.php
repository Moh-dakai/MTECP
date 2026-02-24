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
     * The attributes that are mass assignable. We allow `name`,
     * `color_primary` and `color_secondary` here so callers can simply
     * pass them like normal attributes when creating or updating a tenant.
     * The VirtualColumn trait will automatically move them into the JSON
     * `data` column when the model is saved.
     */
    protected $fillable = [
        'id',
        'data', // still allowed for backwards compatibility with existing code/tests
        'name',
        'color_primary',
        'color_secondary',
    ];

    // We no longer need custom accessors/mutators or appended properties
    // because VirtualColumn already makes `name`, `color_primary`, etc. act
    // like real model attributes. Removing the old methods avoids the
    // encoding conflict that caused test failures.
}
