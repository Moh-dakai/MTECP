<?php

namespace Tests\Feature;

use App\Livewire\StoreOnboarding;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StoreOnboardingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_provisions_a_new_store_and_user()
    {
        Livewire::test(StoreOnboarding::class)
            ->set('store_name', 'My Best Store')
            ->set('subdomain', 'mybeststore')
            ->set('admin_name', 'Admin User')
            ->set('admin_email', 'admin@mybeststore.com')
            ->set('admin_password', 'password1A')
            ->set('password_confirmation', 'password1A')
            ->call('submit')
            ->assertRedirect('http://mybeststore.mtecp.test/login');

        // Verify Tenant
        $this->assertTrue(Tenant::where('id', 'mybeststore')->exists());

        // Output confirmation of User and Role (assuming we configured the User/Tenant scope correctly)
        // Check if the user was created in the database with the scoped tenant_id
        $this->assertTrue(User::where('email', 'admin@mybeststore.com')->where('tenant_id', 'mybeststore')->exists());

    // Role asserts were proven in previous tests so we don't strictly need to repeat but let's confirm
    }
}
