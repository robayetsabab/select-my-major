<?php

use App\Http\Controllers\Api\MajorApiController;
use App\Http\Controllers\Api\QuestionApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/majors', [MajorApiController::class, 'index']);
    Route::get('/majors/compare', [MajorApiController::class, 'compare']);
    
Route::apiResource('/questions', QuestionApiController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy'])
    ->names([
        'index' => 'api.questions.index',
        'store' => 'api.questions.store',
        'show' => 'api.questions.show',
        'update' => 'api.questions.update',
        'destroy' => 'api.questions.destroy',
    ]);

});
