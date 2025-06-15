<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReimbursementController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'listForEmployee']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Employee
    Route::middleware('role:employee')->group(function () {
        Route::apiResource('/reimbursements', ReimbursementController::class)
            ->only(['index', 'store', 'update', 'show', 'destroy']);
    });

    // Manager
    Route::middleware('role:manager')->prefix('manager')->group(function () {
        Route::get('/reimbursementsManager', [ReimbursementController::class, 'managerIndex']);
        // Route::get('/reimbursementsAll', [ReimbursementController::class, 'managerGetAll']);
        Route::patch('/reimbursements/{id}/status', [ReimbursementController::class, 'updateStatus']);
    });

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/cek-softdelete', [ReimbursementController::class, 'cekSoftDelete']);
        Route::get('/reimbursementsAdmin', [ReimbursementController::class, 'adminIndex']);
        Route::get('/categoryAdmin', [CategoryController::class, 'indexAdmin']);
        Route::post('/categoryAdmin', [CategoryController::class, 'store']);
        Route::patch('/categoryAdmin/{category}', [CategoryController::class, 'update']);
        Route::get('/categoryAdminShow/{id}', [CategoryController::class, 'show']);
    });
});
