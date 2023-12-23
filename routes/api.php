<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use App\Http\Middleware\ValidateLimitStudentsToUser;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
    Route::post('students', [StudentsController::class, 'store'])->middleware(ValidateLimitStudentsToUser::class);
    Route::get('students', [StudentsController::class, 'index']);
    Route::put('students/{id}', [StudentsController::class, 'update']);
    Route::delete('students/{id}', [StudentsController::class, 'destroy']);
    Route::get('students/{id}', [StudentsController::class, 'show']);
    Route::get('/students/{id}/workouts', [StudentsController::class, 'showWorkoutsStudents']);
    Route::post('workouts', [WorkoutController::class, 'store']);


    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('dashboard', [DashboardController::class, 'index']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
