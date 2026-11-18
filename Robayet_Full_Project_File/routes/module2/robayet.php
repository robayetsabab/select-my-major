<?php
use App\Http\Controllers\Module2\CareerStoryController;
use App\Http\Controllers\Module2\Module2ApiController;
use App\Http\Controllers\Module2\QuizController;
use Illuminate\Support\Facades\Route;
Route::prefix('career-stories')->name('career-stories.')->group(function(){Route::get('/',[CareerStoryController::class,'index'])->name('index');Route::get('/{story:slug}',[CareerStoryController::class,'show'])->name('show');});
Route::prefix('major-quiz')->name('major-quiz.')->group(function(){Route::get('/',[QuizController::class,'index'])->name('index');Route::post('/submit',[QuizController::class,'submit'])->name('submit');Route::get('/history',[QuizController::class,'history'])->name('history');});
Route::prefix('api/module2')->name('api.module2.')->group(function(){Route::get('/career-stories',[Module2ApiController::class,'stories'])->name('career-stories');Route::get('/majors',[Module2ApiController::class,'majors'])->name('majors');});