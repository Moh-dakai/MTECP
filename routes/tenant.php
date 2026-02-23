<?php

declare(strict_types = 1)
;

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/* |-------------------------------------------------------------------------- | Tenant Routes |-------------------------------------------------------------------------- | | Here you can register the tenant routes for your application. | These routes are loaded by the TenantRouteServiceProvider. | | Feel free to customize them however you want. Good luck! | */

\Illuminate\Support\Facades\Log::info('Evaluating routes/tenant.php');

// Apply tenancy middleware to all tenant routes
Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return view('storefront.home');
    });

    // Storefront routes
    Route::get('/cart', \App\Livewire\Storefront\Cart::class)->name('cart');
    Route::get('/checkout', \App\Livewire\Storefront\Checkout::class)->name('checkout');
    Route::get('/payment/callback/{provider}', [\App\Http\Controllers\PaymentController::class , 'callback'])->name('payment.callback');

    // Admin Dashboard Routes for Tenant
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('categories');
        Route::get('/products', \App\Livewire\Admin\ProductManager::class)->name('products');
        Route::get('/orders', \App\Livewire\Admin\OrderManager::class)->name('orders');
    });
});
