<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use App\Livewire\Central\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CentralAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_central_admin_can_view_and_delete_tenants(): void
    {
        // 1. Create a platform super-admin (or just a user on central domain)
        $admin = User::factory()->create();

        // 2. Create a test tenant
        $tenantId = 'test-store-1';
        $tenant = Tenant::create([
            'id' => $tenantId,
            'name' => 'My Test Store',
        ]);
        // ensure the tenant has a domain so the view shows links
        $tenant->domains()->create(['domain' => 'test1.localhost']);

        // Assert tenant was created
        $this->assertDatabaseHas('tenants', ['id' => $tenantId]);

        // 3. Test the Livewire Component rendering and filtering
        Livewire::actingAs($admin)
            ->test(TenantManager::class)
            ->assertSee('test-store-1')
            ->assertSee('My Test Store')
            ->set('search', 'NonExistentStore')
            ->assertDontSee('test-store-1')
            ->set('search', '')

            // 4. Test Suspension Toggling
            ->call('toggleSuspension', $tenantId)
            ->assertSee('Tenant suspension toggled successfully');

        // Refresh and ensure the virtual attribute is toggled. The
        // VirtualColumn trait will decode `data` and make `is_suspended`
        // available as a normal property, so we can assert directly.
        $tenant->refresh();
        $this->assertTrue($tenant->is_suspended ?? false);

        // 5. Test Deletion
        Livewire::actingAs($admin)
            ->test(TenantManager::class)
            ->call('deleteTenant', $tenantId)
            ->assertSee('Tenant deleted permanently');

        // Assert tenant was removed from DB (stancl/tenancy will handle the rest)
        $this->assertDatabaseMissing('tenants', ['id' => $tenantId]);
        $this->assertDatabaseMissing('domains', ['domain' => 'test1.localhost']);
    }
}
