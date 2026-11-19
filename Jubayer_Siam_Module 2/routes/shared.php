<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
Route::get('/majors/{major:slug}', [MajorController::class, 'show'])->name('majors.show');
Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Quiz is a registered-student feature (Feature 13).
Route::middleware('auth')->group(function () {
    Route::get('/quiz', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz', [QuizController::class, 'submit'])->name('quiz.submit');
});
