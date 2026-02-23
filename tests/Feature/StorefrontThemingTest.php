<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontThemingTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_renders_tenant_brand_colors(): void
    {
        $tenantId = 'brandtest-' . uniqid();
        $tenant = Tenant::create([
            'id' => $tenantId,
            'name' => 'Custom Brand Store',
            'color_primary' => '#ff0000',
            'color_secondary' => '#00ff00',
        ]);
        $tenant->domains()->create(['domain' => $tenantId . '.mtecp.test']);

        $response = $this->get('http://' . $tenantId . '.mtecp.test/');

        $response->assertStatus(200);
        $response->assertSee('Custom Brand Store');
        $response->assertSee('--color-primary: #ff0000', false);
        $response->assertSee('--color-secondary: #00ff00', false);
    }
}
