<?php

use Illuminate\Support\Facades\Route;

// Default welcome page for when no tenant is detected (fallback for testing)

// Routes for central domains (admin, dashboard, etc.)
// These routes will only be accessible if tenancy is NOT initialized
foreach (config('tenancy.central_domains', ['127.0.0.1', 'localhost', 'mtecp.test']) as $domain) {
    Route::domain($domain)->middleware(['web'])->group(function () {
        Route::get('/', function () {
                return view('welcome');
            }
            )->name('home');

            Route::get('dashboard', function () {
                return view('dashboard');
            }
            )->middleware(['auth', 'verified'])->name('dashboard');

            Route::get('profile', function () {
                return view('profile');
            }
            )->middleware(['auth'])->name('profile');

            // Central Admin Routes
            Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
                Route::get('/tenants', \App\Livewire\Central\TenantManager::class)->name('tenants');
                Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('categories');
                Route::get('/products', \App\Livewire\Admin\ProductManager::class)->name('products');
                Route::get('/orders', \App\Livewire\Admin\OrderManager::class)->name('orders');
            }
            );
        });
}

// Auth routes - available on any domain
require __DIR__ . '/auth.php';
