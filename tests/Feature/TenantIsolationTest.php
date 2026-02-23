<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_are_strictly_isolated_by_tenant(): void
    {
        // 1. Create Tenant A & B
        $tenantA = Tenant::create(['id' => 'tenant-a']);
        $tenantB = Tenant::create(['id' => 'tenant-b']);

        // 2. Initialize App as Tenant A and create a Product
        tenancy()->initialize($tenantA);
        $productA = Product::create([
            'name' => 'Widget A',
            'slug' => 'widget-a',
            'price_cents' => 1000,
            'stock' => 50,
        ]);
        tenancy()->end();

        // 3. Initialize App as Tenant B and create a distinct Product
        tenancy()->initialize($tenantB);
        $productB = Product::create([
            'name' => 'Widget B',
            'slug' => 'widget-b',
            'price_cents' => 2000,
            'stock' => 10,
        ]);

        // 4. Assert Tenant B only sees Widget B, not Widget A
        $this->assertEquals(1, Product::count());
        $this->assertEquals('Widget B', Product::first()->name);

        tenancy()->end();

        // 5. Assert global context contains both
        $this->assertEquals(2, Product::withoutTenancy()->count());
    }
}
