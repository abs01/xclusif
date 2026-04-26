<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FollowerCRUDController;
use App\Http\Controllers\LikeCRUDController;
use App\Http\Controllers\PostCRUDController;
use App\Http\Controllers\UserCRUDController;
use App\Http\Controllers\CommentCRUDController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('CHECK-ROLEADMIN')->group(function () {
        Route::resource('userCRUD', UserCRUDController::class);
        Route::resource('followerCRUD', FollowerCRUDController::class);
        Route::resource('postCRUD', PostCRUDController::class);
        Route::resource('likeCRUD', LikeCRUDController::class);
        Route::resource('commentCRUD', CommentCRUDController::class);

    });
});

require __DIR__.'/auth.php';
