<?php

use App\Http\Controllers\Api\CertificationApiController;
use App\Http\Controllers\Api\MajorApiController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\MajorController;
use Illuminate\Support\Facades\Route;

// Robayet's assigned features: Major Overview & Selection, and Certifications & Learning Resources.
Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
Route::get('/majors/{major}', [MajorController::class, 'show'])->name('majors.show');
Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');

// Read-only catalog API for the existing major and certification data.
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/majors', [MajorApiController::class, 'index'])->name('majors.index');
    Route::get('/majors/compare', [MajorApiController::class, 'compare'])->name('majors.compare');
    Route::get('/majors/{major}', [MajorApiController::class, 'show'])->name('majors.show');
    Route::get('/certifications', [CertificationApiController::class, 'index'])->name('certifications.index');
    Route::get('/certifications/{certification}', [CertificationApiController::class, 'show'])->name('certifications.show');
});
