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


    Route::patch('/films/{film}', [FilmsController::class, 'change'])->name('film.change');
    Route::get('/favorite', [FavoriteController::class, 'get'])->name('film.favorites.get');
    Route::post('/films/{film}/favorite', [FavoriteController::class, 'add'])->name('film.favorite.add');
    Route::delete('/films/{film}/favorite', [FavoriteController::class, 'delete'])->name('film.favorite.delete');

    Route::post('/comments/{film}', [CommentController::class, 'add'])->name('comment.add');
    Route::patch('/comments/{comment}', [CommentController::class, 'change'])->name('comment.change');
    Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comment.delete');

    Route::post('/promo/{film}', [PromoController::class, 'add'])->name('promo.add');

    Route::post('/genres', [GenreController::class, 'add'])->name('genre.add');
    Route::patch('/genres/{genre}', [GenreController::class, 'change'])->name('genre.change');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/films', [FilmsController::class, 'getAll'])->name('films.get');
Route::get('/films/{film}', [FilmsController::class, 'get'])->name('film.get');
Route::get('/films/{film}/similar', [FilmsController::class, 'similar'])->name('film.similar.get');

Route::get('/promo', [PromoController::class, 'get'])->name('promo.get');

Route::get('/comments/{film}', [CommentController::class, 'getAll'])->name('comments.get');

Route::get('/genres', [GenreController::class, 'getAll'])->name('genres.get');

Route::post('/films', [FilmsController::class, 'add'])->name('film.add');
