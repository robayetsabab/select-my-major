
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CompareController;

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/compare', [CompareController::class, 'index'])
        ->name('compare.index');

    Route::resource('questions', QuestionController::class)
        ->only(['index', 'create', 'store', 'show']);

    Route::patch('/questions/{question}/moderate',
        [QuestionController::class, 'moderate'])
        ->name('questions.moderate');
});
