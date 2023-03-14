<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/films', [FilmsController::class, 'getAll']);
Route::get('/films/{film}', [FilmsController::class, 'get']);
Route::get('/films/{film}/similar', [FilmsController::class, 'similar']);
Route::post('/films', [FilmsController::class, 'add']);
Route::patch('/films/{filmId}', [FilmsController::class, 'change']);

Route::get('/promo', [PromoController::class, 'get']);

Route::get('/favorite', [FavoriteController::class, 'get']);
Route::post('/favorite/{filmId}/{status}', [FavoriteController::class, 'add']);
Route::delete('/favorite/{filmId}', [FavoriteController::class, 'delete']);

Route::get('/comments/{filmId}', [CommentController::class, 'get']);
Route::post('/comments/{filmId}', [CommentController::class, 'add']);
Route::patch('/comments/{commentId}', [CommentController::class, 'change']);
Route::delete('/comments/{commentId}', [CommentController::class, 'delete']);

Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);

Route::delete('/logout', [AuthController::class, 'logout']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/user', [UserController::class, 'get']);
Route::patch('/user', [UserController::class, 'change']);

Route::get('/genres', [GenreController::class, 'getAll']);
Route::patch('/genres/{genre}', [GenreController::class, 'change']);

