<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Sort
Route::get('posts', [PostController::class, 'index']);
// Create
Route::post('posts', [PostController::class, 'store']);
// Update
Route::put('posts/{post}', [PostController::class, 'update']);
// Delete
Route::delete('posts/{post}', [PostController::class, 'destroy']);
// Search
Route::get('posts/search', [PostController::class, 'search']);
// Set Active
Route::patch('posts/{post}/activate', [PostController::class, 'setActive']);
// Set Inactive
Route::patch('posts/{post}/deactivate', [PostController::class, 'setInactive']);
// Ordering
Route::post('posts/order', [PostController::class, 'order']);
