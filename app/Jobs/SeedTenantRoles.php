<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Permission\Models\Role;

class SeedTenantRoles implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Tenant $tenant)
    {
    //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Spatie handles teams using the 'tenant_id' which is stored in the session or cache.
        // It's safer to explicitly set it here before generating the tenant roles.
        setPermissionsTeamId($this->tenant->id);

        $roles = ['Store Administrator', 'Store Manager', 'Customer'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'tenant_id' => $this->tenant->id,
                'guard_name' => 'web',
            ]);
        }
    }
}
