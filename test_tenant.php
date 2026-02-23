<?php

use App\Models\Tenant;

$tenant = Tenant::create([
    'id' => 'test-store-1',
    'data' => []
]);
$currentData = is_array($tenant->data) ? $tenant->data : [];
$currentData['is_suspended'] = true;
$tenant->update(['data' => $currentData]);
$tenant->refresh();
var_dump($tenant->data);
var_dump($tenant->is_suspended);
