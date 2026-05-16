<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FollowerController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ========================================
// RUTAS PÚBLICAS (sin autenticación)
// ========================================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
  // Obtener usuario autenticado
  
    // Binding de 'user' (debe estar antes de las rutas que lo utilizan)

Route::get('/user/{user}/is_tier_premium', [UserController::class, 'isTierPremium']);

// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Route::get('/followers', [FollowerController::class, 'index']);
// Route::get('/followers/{id}', [FollowerController::class, 'show']);
// Route::post('/followers', [FollowerController::class, 'store']);
// Route::put('/followers/{id}', [FollowerController::class, 'update']);
// Route::delete('/followers/{id}', [FollowerController::class, 'destroy']);

// Route::get('/posts', [PostController::class, 'index']);
// Route::get('/posts/{id}', [PostController::class, 'show']);



// ========================================
// RUTAS PROTEGIDAS
// ========================================


// Autenticación

Route::middleware('MULTI-AUTH')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Users routes
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    
    Route::apiResource('followers', FollowerController::class)->except(['index', 'show']);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('likes', LikeController::class);
    Route::apiResource('comments', CommentController::class)->except(['destroy']);

    Route::middleware('CHECK-ROLEADMIN')->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
        Route::get('/followers', [FollowerController::class, 'index']);
        Route::get('/followers/{id}', [FollowerController::class, 'show']);
    });
});
