<?php

use App\Http\Controllers\Api\ExploreApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/majors', [ExploreApiController::class, 'majors'])->name('majors.index');
    Route::get('/subfields', [ExploreApiController::class, 'subfields'])->name('subfields.index');
    Route::get('/subfields/{subfield:slug}', [ExploreApiController::class, 'subfield'])->name('subfields.show');
    Route::get('/careers', [ExploreApiController::class, 'careers'])->name('careers.index');
    Route::get('/careers/{career:slug}', [ExploreApiController::class, 'career'])->name('careers.show');
    Route::get('/search', [ExploreApiController::class, 'search'])->name('search');
});
