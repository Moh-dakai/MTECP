<?php

use Illuminate\Support\Facades\Route;

// Default welcome page for when no tenant is detected (fallback for testing)
Route::view('/', 'welcome')->name('home');

// Auth routes - available on any domain
require __DIR__ . '/auth.php';

// Routes for central domains (admin, dashboard, etc.)
// Include localhost and 127.0.0.1 as central domains for testing
foreach (['localhost', '127.0.0.1', 'mtecp.test'] as $domain) {
    Route::domain($domain)->group(function () {
        Route::view('dashboard', 'dashboard')
            ->middleware(['auth', 'verified'])
            ->name('dashboard');

        Route::view('profile', 'profile')
            ->middleware(['auth'])
            ->name('profile');

        // Central Admin Route
        Route::get('admin/tenants', \App\Livewire\Central\TenantManager::class)
            ->middleware(['auth'])
            ->name('admin.tenants');
    });
}
