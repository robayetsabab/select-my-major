<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Shared pages (majors, certifications, login, quiz) - replace with the group's versions when merging.
require __DIR__ . '/shared.php';

// Each team member keeps their own routes in routes/module1/<name>.php and routes/module2/<name>.php
foreach (array_merge(glob(__DIR__ . '/module1/*.php'), glob(__DIR__ . '/module2/*.php')) as $routeFile) {
    require $routeFile;
}
