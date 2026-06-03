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
use App\Http\Controllers\Api\SponsorController;
// ========================================
// RUTAS PÚBLICAS (sin autenticación)
// ========================================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
  // Obtener usuario autenticado
Route::get('/user/{user}/is_tier_premium', [UserController::class, 'isTierPremium']);
    Route::apiResource('sponsors', SponsorController::class)->except('update', 'edit','create','destroy');

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
    
    Route::apiResource('posts', PostController::class);
    Route::apiResource('likes', LikeController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('followers', FollowerController::class);

    Route::post('/posts/{post}/image', [PostController::class, 'image']);
    Route::post('/followers/{id}/make-vip', [FollowerController::class, 'makeVip']);    
    Route::get('/followers/{id}/following', [FollowerController::class, 'getFollowing']);
    Route::middleware('CHECK-ROLEADMIN')->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
});
