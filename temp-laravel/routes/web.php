<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\MajorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MajorController::class, 'index'])->name('home');
Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
Route::get('/majors/{major}', [MajorController::class, 'show'])->name('majors.show');
Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');

// Teammates: add your routes (subfields, roadmap, careers, salary) below this line
