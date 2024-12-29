<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplyController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    // Route::post('validator/login', [ValidationController::class, 'loginValidator']);
    // Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('validations', [ValidationController::class, 'store']);
        Route::get('validations', [ValidationController::class, 'show']);
        Route::get('job_vacancies', [JobVacancyController::class, 'index']);
        Route::get('job_vacancies/{id}', [JobVacancyController::class, 'show']);
        Route::post('applications', [JobApplyController::class, 'store']);
        Route::get('applications', [JobApplyController::class, 'index']);
    });
});



