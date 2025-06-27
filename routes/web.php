<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return redirect(\App\Filament\Resources\QuizResource::getUrl());
})->name('login');

Route::get('quizzes', [QuizController::class, 'index']);
Route::get('quizzes/{quiz}', [QuizController::class, 'show'])->middleware('auth');
Route::get('quizzes/{quiz}/attempt', [AttemptController::class, 'new'])->middleware('auth')->name('quiz.attempt');
Route::get('attempt/{attempt}', [AttemptController::class, 'view'])->middleware('auth')->name('attempt.view');
