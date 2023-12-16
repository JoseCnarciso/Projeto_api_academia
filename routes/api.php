<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
    Route::post('students', [StudentsController::class, 'store']);
    Route::get('students', [StudentsController::class, 'index']);
    Route::delete('students/{id}', [StudentsController::class, 'destroy']);
    Route::put('students/{id}', [StudentsController::class, 'update']);

    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
