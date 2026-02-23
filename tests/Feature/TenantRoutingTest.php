<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;

class TenantRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_routing_works_with_domain(): void
    {
        $this->withoutExceptionHandling();
        // Add mtecp.test to prevent central domain blocks if we are running in a weird environment, but config already has it.
        $tenant = Tenant::create(['id' => 'storetest1']);
        $tenant->domains()->create(['domain' => 'storetest1.mtecp.test']);

        $response = $this->get('http://storetest1.mtecp.test/');

        $response->assertStatus(200);
        $response->assertViewIs('storefront.home');
    }
}
