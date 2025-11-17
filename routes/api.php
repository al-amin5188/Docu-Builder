<?php

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Only Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return ['message' => 'Admin Dashboard'];
        });
    });

    // Only Editor
    Route::middleware('role:editor')->group(function () {
        Route::get('/editor/dashboard', function () {
            return ['message' => 'Editor Dashboard'];
        });
    });
});


Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password',  [AuthController::class, 'resetPassword']);
