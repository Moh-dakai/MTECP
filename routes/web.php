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

            // Central Admin Route
            Route::get('admin/tenants', \App\Livewire\Central\TenantManager::class)
                ->middleware(['auth'])
                ->name('admin.tenants');
        });
}

// Auth routes - available on any domain
require __DIR__ . '/auth.php';
