<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\UserCRUDController;
use App\Http\Controllers\FollowerCRUDController;


// ========================================
// RUTAS PÚBLICAS (sin autenticación)
// ========================================

// Autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/users', [UserCRUDController::class, 'index']);
Route::get('/users/{id}', [UserCRUDController::class, 'show']);
Route::post('/users', [UserCRUDController::class, 'store']);
Route::put('/users/{id}', [UserCRUDController::class, 'update']);
Route::delete('/users/{id}', [UserCRUDController::class, 'destroy']);

Route::get('/followers', [FollowerCRUDController::class, 'index']);
Route::get('/followers/{id}', [FollowerCRUDController::class, 'show']);
Route::post('/followers', [FollowerCRUDController::class, 'store']);
Route::put('/followers/{id}', [FollowerCRUDController::class, 'update']);
Route::delete('/followers/{id}', [FollowerCRUDController::class, 'destroy']);

// ========================================
// RUTAS PROTEGIDAS
// ========================================

Route::middleware('MULTI-AUTH')->group(function () {
 Route::post('/logout', [AuthController::class, 'logout']);
});