<?php

declare(strict_types = 1)
;

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/* |-------------------------------------------------------------------------- | Tenant Routes |-------------------------------------------------------------------------- | | Here you can register the tenant routes for your application. | These routes are loaded by the TenantRouteServiceProvider. | | Feel free to customize them however you want. Good luck! | */
throw new \Exception('TENANT.PHP IS BEING EXECUTED!');
\Illuminate\Support\Facades\Log::info('Evaluating routes/tenant.php');

Route::get('/', function () {
    return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
});
