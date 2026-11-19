<?php

use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

// Feature 8: Senior Students' Experiences (public to read)
Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');
Route::get('/experiences/{experience}', [ExperienceController::class, 'show'])->whereNumber('experience')->name('experiences.show');
Route::post('/experiences/{experience}/helpful', [ExperienceController::class, 'helpful'])
    ->whereNumber('experience')->middleware('auth')->name('experiences.helpful');

// Feature 11: Recommendation System (registered students only)
Route::middleware('auth')->group(function () {
    Route::get('/my/recommendations', [RecommendationController::class, 'history'])->name('recommendation.history');
    Route::get('/recommendation/{attempt}', [RecommendationController::class, 'show'])->whereNumber('attempt')->name('recommendation.show');
});
