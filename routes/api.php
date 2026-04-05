<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Requires Sanctum Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |----------------------------------------------------------------------
    | Admin Only Management Routes
    |----------------------------------------------------------------------
    | All routes here are protected by 'role:admin' middleware
    */
    Route::middleware('role:admin')->prefix('admin')->group(function () {

        // Full CRUD for User Management
        Route::apiResource('users', AdminUserController::class);

        // Custom Role Management (if needed separately)
        Route::post('users/{id}/make-admin', [AdminUserController::class, 'makeAdmin']);
        Route::post('users/{id}/remove-admin', [AdminUserController::class, 'removeAdmin']);
    });

});
