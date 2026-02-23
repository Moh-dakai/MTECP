<?php

use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::view('/', 'welcome');

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

        require __DIR__ . '/auth.php';
    });
}
