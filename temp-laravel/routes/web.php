<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

foreach (glob(__DIR__ . '/module1/*.php') as $routeFile) {
    require $routeFile;
}

foreach (glob(__DIR__ . '/module2/*.php') as $routeFile) {
    require $routeFile;
}
