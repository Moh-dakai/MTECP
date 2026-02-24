<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;

// create test tenant
$t = Tenant::create(['id' => 'debugtest2', 'data' => ['name' => 'My Test Store']]);
print_r($t->data);
print("\nName: ".$t->name."\n");

// fetch again fresh from DB
$t2 = Tenant::find('debugtest2');
print_r($t2->data);
print("\nName2: ".$t2->name."\n");
