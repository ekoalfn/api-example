<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthenticationController;

Route::post('/login', [AuthenticationController::class, 'login']);

Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/posts', [PostsController::class, 'store']);
    Route::patch('/posts/{id}', [PostsController::class, 'update'])->middleware('author-post');

    Route::get('/logout', [AuthenticationController::class, 'logout']);
});

