<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('users/login', 'login');
    Route::post('users/register', 'register');
    Route::post('users/logout', 'logout');
    Route::post('users/refresh', 'refresh');
    Route::get('users/profile', 'show')->middleware('auth:api');;
    Route::put('users/profile', 'update')->middleware('auth:api');;
});

Route::controller(AuthorController::class)->group(function () {
    Route::get('authors/', 'index');
    Route::post('authors/', 'store')->middleware('is_admin');;
    Route::get('authors/{author}', 'show');
    Route::put('authors/{author}', 'update')->middleware('is_admin');;
    Route::delete('authors/{author}', 'destroy')->middleware('is_admin');;
});

Route::controller(BookController::class)->group(function () {
    Route::get('books/', 'index');
    Route::post('books/', 'store')->middleware('is_admin');;
    Route::get('books/{book}', 'show');
    Route::put('books/{book}', 'update')->middleware('is_admin');;
    Route::delete('books/{book}', 'destroy')->middleware('is_admin');;
});

Route::post('reviews/books/{book}',[BookController::class, 'storeReview']);
Route::post('reviews/authors/{author}', [AuthorController::class, 'storeReview']);
Route::get('reviews', [ReviewController::class, 'index']);
Route::put('reviews/{id}', [ReviewController::class, 'update'])->middleware('is_original_reviewer');
Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->middleware(['is_original_reviewer', 'is_admin']);

Route::get('notifications', [NotificationController::class, 'index'])->middleware('auth:api');;
Route::put('notifications/{notification}/read', [NotificationController::class, 'read'])->middleware('auth:api');;

