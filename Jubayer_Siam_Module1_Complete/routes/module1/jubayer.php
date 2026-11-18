<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\SubfieldController;
use Illuminate\Support\Facades\Route;

// Feature 2: Subfields and Details
Route::get('/subfields', [SubfieldController::class, 'index'])->name('subfields.index');
Route::get('/subfields/{subfield:slug}', [SubfieldController::class, 'show'])->name('subfields.show');

// Feature 5: Career Opportunities and Career Path
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::get('/careers/{career:slug}', [CareerController::class, 'show'])->name('careers.show');
