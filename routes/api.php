<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\EnsureCommentExists;
use App\Http\Middleware\EnsureFilmExists;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UsersController::class, 'get'])->name('user.get');
    Route::patch('/user', [UsersController::class, 'change'])->name('user.change');

    Route::patch('/films/{film}', [FilmsController::class, 'change'])
        ->middleware(EnsureFilmExists::class)
        ->name('film.change');
    Route::get('/favorite', [FavoritesController::class, 'get'])->name('film.favorites.get');
    Route::post('/films/{film}/favorite', [FavoritesController::class, 'add'])
        ->middleware(EnsureFilmExists::class)
        ->name('film.favorite.add');
    Route::delete('/films/{film}/favorite', [FavoritesController::class, 'delete'])
        ->middleware(EnsureFilmExists::class)
        ->name('film.favorite.delete');

    Route::post('/comments/{film}', [CommentsController::class, 'add'])
        ->middleware(EnsureFilmExists::class)
        ->name('comment.add');
    Route::patch('/comments/{comment}', [CommentsController::class, 'change'])
        ->middleware(EnsureCommentExists::class)
        ->name('comment.change');
    Route::delete('/comments/{comment}', [CommentsController::class, 'delete'])
        ->middleware(EnsureCommentExists::class)
        ->name('comment.delete');

    Route::post('/promo/{film}', [PromoController::class, 'add'])
        ->middleware(EnsureFilmExists::class)
        ->name('promo.add');

    Route::post('/genres', [GenresController::class, 'add'])->name('genre.add');
    Route::patch('/genres/{genre}', [GenresController::class, 'change'])->name('genre.change');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::post('/films', [FilmsController::class, 'add'])->name('film.add');
Route::get('/films', [FilmsController::class, 'getAll'])->name('films.get');
Route::get('/films/{film}', [FilmsController::class, 'get'])
    ->middleware(EnsureFilmExists::class)
    ->name('film.get');
Route::get('/films/{film}/similar', [FilmsController::class, 'similar'])
    ->middleware(EnsureFilmExists::class)
    ->name('film.similar.get');

Route::get('/promo', [PromoController::class, 'get'])->name('promo.get');

Route::get('/comments/{film}', [CommentsController::class, 'getAll'])
    ->middleware(EnsureFilmExists::class)
    ->name('comments.get');

Route::get('/genres', [GenresController::class, 'getAll'])->name('genres.get');
