<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Each team member keeps their web and API routes in routes/module1/<member>.php.
foreach (glob(__DIR__ . '/module1/*.php') as $routeFile) {
    require $routeFile;
}
