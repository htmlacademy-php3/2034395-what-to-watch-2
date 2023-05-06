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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'get'])->name('user.get');
    Route::patch('/user', [UserController::class, 'change'])->name('user.change');
    Route::post('/films', [FilmsController::class, 'add'])->name('film.add');
    Route::patch('/films/{film}', [FilmsController::class, 'change'])->name('film.change');
    Route::patch('/comments/{comment}', [CommentController::class, 'change'])->name('comment.change');
    Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::get('/favorite', [FavoriteController::class, 'get'])->name('favorite.get');
    Route::post('/favorite/{film}/{status}', [FavoriteController::class, 'add'])->name('favorite.add');
    Route::delete('/favorite/{film}', [FavoriteController::class, 'delete'])->name('favorite.delete');
    Route::post('/promo/{film}', [PromoController::class, 'add'])->name('promo.add');
    Route::post('/genres', [GenreController::class, 'add'])->name('genre.add');
    Route::patch('/genres/{genre}', [GenreController::class, 'change'])->name('genre.change');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/films', [FilmsController::class, 'getAll'])->name('films.get');
Route::get('/films/{film}', [FilmsController::class, 'get'])->name('film.get');
Route::get('/films/{film}/similar', [FilmsController::class, 'similar'])->name('similar.get');

Route::get('/promo', [PromoController::class, 'get'])->name('promo.get');

Route::get('/comments/{type}/{id}', [CommentController::class, 'getAll'])->name('comments.get');
Route::post('/comments/{type}/{id}', [CommentController::class, 'add'])->name('comment.add');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/genres', [GenreController::class, 'getAll'])->name('genres.get');
