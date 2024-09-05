<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AuthenticationController;

Route::post('/login', [AuthenticationController::class, 'login']);

Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/posts', [PostsController::class, 'store']);
    Route::patch('/posts/{id}', [PostsController::class, 'update'])->middleware('author-post');
    Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->middleware('author-post');

    Route::post('/comments', [CommentsController::class, 'store']);
    Route::patch('/comments/{id}', [CommentsController::class, 'update'])->middleware('commentator');
    Route::delete('/comments/{id}', [CommentsController::class, 'destroy'])->middleware('commentator');
    Route::get('/logout', [AuthenticationController::class, 'logout']);
});

