<?php

declare(strict_types = 1)
;

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/* |-------------------------------------------------------------------------- | Tenant Routes |-------------------------------------------------------------------------- | | Here you can register the tenant routes for your application. | These routes are loaded by the TenantRouteServiceProvider. | | Feel free to customize them however you want. Good luck! | */

\Illuminate\Support\Facades\Log::info('Evaluating routes/tenant.php');

Route::get('/', function () {
    return view('storefront.home');
});

// Admin Dashboard Routes for Tenant
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('categories');
    Route::get('/products', \App\Livewire\Admin\ProductManager::class)->name('products');
});
