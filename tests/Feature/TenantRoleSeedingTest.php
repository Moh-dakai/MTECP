<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;

class TenantRoleSeedingTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_creation_seeds_default_roles(): void
    {
        $tenantId = 'role-test-' . uniqid();
        $tenant = Tenant::create([
            'id' => $tenantId
        ]);

        $rolesCount = Role::where('tenant_id', $tenantId)->count();

        $this->assertEquals(3, $rolesCount);
        $this->assertTrue(Role::where('tenant_id', $tenantId)->where('name', 'Store Administrator')->exists());
        $this->assertTrue(Role::where('tenant_id', $tenantId)->where('name', 'Store Manager')->exists());
        $this->assertTrue(Role::where('tenant_id', $tenantId)->where('name', 'Customer')->exists());
    }
}
