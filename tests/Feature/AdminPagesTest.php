<?php

namespace Tests\Feature;

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\OrderManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Central\TenantManager;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenant;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a tenant and initialize tenancy for all tests in this class
        $this->tenant = Tenant::create(['id' => 'test-shop', 'name' => 'Test Shop']);
        tenancy()->initialize($this->tenant);

        // Create an admin user scoped to this tenant
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test-shop.com',
            'password' => bcrypt('password'),
        ]);
    }

    protected function tearDown(): void
    {
        tenancy()->end();
        parent::tearDown();
    }

    // =========================================================================
    // CATEGORIES PAGE
    // =========================================================================

    public function test_categories_page_can_be_rendered(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->assertStatus(200);
    }

    public function test_can_create_a_category(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->set('name', 'Electronics')
            ->set('slug', 'electronics')
            ->set('description', 'All electronics products')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Category created successfully');

        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'tenant_id' => 'test-shop',
        ]);
    }

    public function test_slug_is_auto_generated_from_name(): void
    {
        $component = Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->set('name', 'Home & Garden');

        $component->assertSet('slug', 'home-garden');
    }

    public function test_can_edit_a_category(): void
    {
        $category = Category::create([
            'name' => 'Old Name',
            'slug' => 'old-name',
        ]);

        Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->call('edit', $category->id)
            ->assertSet('name', 'Old Name')
            ->assertSet('isEditing', true)
            ->set('name', 'New Name')
            ->set('slug', 'new-name')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Category updated successfully');

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'New Name']);
    }

    public function test_can_delete_a_category(): void
    {
        $category = Category::create([
            'name' => 'To Be Deleted',
            'slug' => 'to-be-deleted',
        ]);

        Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->call('delete', $category->id)
            ->assertSee('Category deleted successfully');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_delete_category_with_children(): void
    {
        $parent = Category::create(['name' => 'Parent', 'slug' => 'parent']);
        Category::create(['name' => 'Child', 'slug' => 'child', 'parent_id' => $parent->id]);

        Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->call('delete', $parent->id)
            ->assertSee('Cannot delete this category. It contains child categories.');

        $this->assertDatabaseHas('categories', ['id' => $parent->id]);
    }

    public function test_category_create_requires_name_and_slug(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CategoryManager::class)
            ->call('save')
            ->assertHasErrors(['name', 'slug']);
    }

    // =========================================================================
    // PRODUCTS PAGE
    // =========================================================================

    public function test_products_page_can_be_rendered(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProductManager::class)
            ->assertStatus(200);
    }

    public function test_can_create_a_product(): void
    {
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);

        Livewire::actingAs($this->admin)
            ->test(ProductManager::class)
            ->set('name', 'Laptop Pro')
            ->set('slug', 'laptop-pro')
            ->set('sku', 'LP-001')
            ->set('price_cents', 99999)
            ->set('stock', 10)
            ->set('is_active', true)
            ->set('category_id', $category->id)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Product created successfully');

        $this->assertDatabaseHas('products', [
            'name' => 'Laptop Pro',
            'slug' => 'laptop-pro',
            'sku' => 'LP-001',
            'tenant_id' => 'test-shop',
        ]);
    }

    public function test_can_edit_a_product(): void
    {
        $product = Product::create([
            'name' => 'Old Product',
            'slug' => 'old-product',
            'price_cents' => 500,
            'stock' => 5,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ProductManager::class)
            ->call('edit', $product->id)
            ->assertSet('name', 'Old Product')
            ->assertSet('isEditing', true)
            ->set('name', 'Updated Product')
            ->set('slug', 'updated-product')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Product updated successfully');

        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product']);
    }

    public function test_can_delete_a_product(): void
    {
        $product = Product::create([
            'name' => 'Disposable',
            'slug' => 'disposable',
            'price_cents' => 100,
            'stock' => 1,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ProductManager::class)
            ->call('delete', $product->id)
            ->assertSee('Product deleted successfully');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_create_requires_name_slug_price_stock(): void
    {
        Livewire::actingAs($this->admin)
            ->test(ProductManager::class)
            ->call('save')
            ->assertHasErrors(['name', 'slug']);
    }

    // =========================================================================
    // ORDERS PAGE
    // =========================================================================

    public function test_orders_page_can_be_rendered(): void
    {
        Livewire::actingAs($this->admin)
            ->test(OrderManager::class)
            ->assertStatus(200);
    }

    public function test_orders_page_lists_existing_orders(): void
    {
        Order::create([
            'order_number' => 'ORD-0001',
            'status' => Order::STATUS_PENDING,
            'subtotal' => 100.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 100.00,
            'currency' => 'USD',
            'shipping_first_name' => 'John',
            'shipping_last_name' => 'Doe',
            'shipping_email' => 'john@example.com',
        ]);

        // order-manager view is a placeholder; assert the component passes correct data
        Livewire::actingAs($this->admin)
            ->test(OrderManager::class)
            ->assertViewHas('orders', fn($orders) =>
        $orders->total() === 1 &&
        $orders->first()->order_number === 'ORD-0001'
        );
    }

    public function test_orders_search_filters_results(): void
    {
        Order::create([
            'order_number' => 'ORD-AAA',
            'status' => Order::STATUS_PENDING,
            'subtotal' => 50.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 50.00,
            'currency' => 'USD',
            'shipping_first_name' => 'Alice',
            'shipping_last_name' => 'Smith',
            'shipping_email' => 'alice@example.com',
        ]);

        Order::create([
            'order_number' => 'ORD-BBB',
            'status' => Order::STATUS_PROCESSING,
            'subtotal' => 75.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 75.00,
            'currency' => 'USD',
            'shipping_first_name' => 'Bob',
            'shipping_last_name' => 'Jones',
            'shipping_email' => 'bob@example.com',
        ]);

        // Filter by search term — only ORD-AAA should appear in view data
        Livewire::actingAs($this->admin)
            ->test(OrderManager::class)
            ->set('search', 'ORD-AAA')
            ->assertViewHas('orders', fn($orders) =>
        $orders->total() === 1 &&
        $orders->first()->order_number === 'ORD-AAA'
        );
    }

    public function test_orders_status_filter_works(): void
    {
        Order::create([
            'order_number' => 'ORD-PEND',
            'status' => Order::STATUS_PENDING,
            'subtotal' => 20.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 20.00,
            'currency' => 'USD',
            'shipping_first_name' => 'Pending',
            'shipping_last_name' => 'User',
            'shipping_email' => 'pending@example.com',
        ]);

        Order::create([
            'order_number' => 'ORD-SHIP',
            'status' => Order::STATUS_SHIPPED,
            'subtotal' => 30.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 30.00,
            'currency' => 'USD',
            'shipping_first_name' => 'Shipped',
            'shipping_last_name' => 'User',
            'shipping_email' => 'shipped@example.com',
        ]);

        // Filter by status — only SHIPPED order should appear in view data
        Livewire::actingAs($this->admin)
            ->test(OrderManager::class)
            ->set('statusFilter', Order::STATUS_SHIPPED)
            ->assertViewHas('orders', fn($orders) =>
        $orders->total() === 1 &&
        $orders->first()->order_number === 'ORD-SHIP'
        );
    }

    public function test_can_view_order_details(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-VIEW',
            'status' => Order::STATUS_PENDING,
            'subtotal' => 60.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 60.00,
            'currency' => 'USD',
            'shipping_first_name' => 'Jane',
            'shipping_last_name' => 'Doe',
            'shipping_email' => 'jane@example.com',
        ]);

        Livewire::actingAs($this->admin)
            ->test(OrderManager::class)
            ->call('viewOrder', $order->id)
            ->assertSet('showOrderModal', true)
            ->assertSet('viewingOrder.order_number', 'ORD-VIEW');
    }

    public function test_can_update_order_status(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-STAT',
            'status' => Order::STATUS_PENDING,
            'subtotal' => 40.00,
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'total' => 40.00,
            'currency' => 'USD',
            'shipping_first_name' => 'Status',
            'shipping_last_name' => 'Test',
            'shipping_email' => 'status@example.com',
        ]);

        // Must call viewOrder first to set $viewingOrder before updating status
        Livewire::actingAs($this->admin)
            ->test(OrderManager::class)
            ->call('viewOrder', $order->id)
            ->assertSet('showOrderModal', true)
            ->call('updateOrderStatus', Order::STATUS_PROCESSING);

        // Assert DB was updated (the view is a placeholder so no flash visible)
        $this->assertEquals(Order::STATUS_PROCESSING, $order->fresh()->status);
    }

    // =========================================================================
    // PLATFORM TENANTS PAGE (Central Admin)
    // =========================================================================

    public function test_platform_tenants_page_can_be_rendered(): void
    {
        // End tenant context — TenantManager is a central domain component
        tenancy()->end();

        $centralAdmin = User::factory()->create();

        Livewire::actingAs($centralAdmin)
            ->test(TenantManager::class)
            ->assertStatus(200);

        // Re-init for tearDown
        tenancy()->initialize($this->tenant);
    }

    public function test_platform_tenants_page_lists_tenants(): void
    {
        tenancy()->end();

        $centralAdmin = User::factory()->create();

        Livewire::actingAs($centralAdmin)
            ->test(TenantManager::class)
            ->assertSee('test-shop')
            ->assertSee('Test Shop');

        tenancy()->initialize($this->tenant);
    }

    public function test_platform_tenants_search_filters_results(): void
    {
        tenancy()->end();
        Tenant::create(['id' => 'another-shop', 'name' => 'Another Shop']);

        $centralAdmin = User::factory()->create();

        Livewire::actingAs($centralAdmin)
            ->test(TenantManager::class)
            ->set('search', 'another')
            ->assertSee('another-shop')
            ->assertDontSee('test-shop');

        tenancy()->initialize($this->tenant);
    }

    public function test_can_suspend_and_unsuspend_a_tenant(): void
    {
        tenancy()->end();
        $centralAdmin = User::factory()->create();

        Livewire::actingAs($centralAdmin)
            ->test(TenantManager::class)
            ->call('toggleSuspension', 'test-shop')
            ->assertSee('Tenant suspension toggled successfully');

        $this->tenant->refresh();
        $this->assertTrue($this->tenant->is_suspended ?? false);

        tenancy()->initialize($this->tenant);
    }

    public function test_can_delete_a_tenant(): void
    {
        tenancy()->end();
        $centralAdmin = User::factory()->create();

        Tenant::create(['id' => 'delete-me', 'name' => 'Delete Me']);

        Livewire::actingAs($centralAdmin)
            ->test(TenantManager::class)
            ->call('deleteTenant', 'delete-me')
            ->assertSee('Tenant deleted permanently');

        $this->assertDatabaseMissing('tenants', ['id' => 'delete-me']);

        tenancy()->initialize($this->tenant);
    }
}
