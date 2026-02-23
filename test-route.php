<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$routes = app(\Illuminate\Routing\Router::class)->getRoutes();
$match = $routes->match($request);
echo "Matched Route Name: " . $match->getName() . "\n";
echo "Matched Route Action: " . json_encode($match->getAction()) . "\n";
