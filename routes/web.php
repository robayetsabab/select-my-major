<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MajorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/majors', [MajorController::class, 'index']);

Route::get('/majors/{slug}', [MajorController::class, 'show']);