<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Cek mode maintenance (Arahkan ke folder coin-web)
if (file_exists($maintenance = __DIR__.'/../coin-web/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Register Autoloader (Arahkan ke folder coin-web/vendor)
require __DIR__.'/../coin-web/vendor/autoload.php';

// 3. Bootstrap Laravel (Arahkan ke folder coin-web/bootstrap)
(require_once __DIR__.'/../coin-web/bootstrap/app.php')
    ->handleRequest(Request::capture());