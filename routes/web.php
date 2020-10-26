<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect('/', '/register');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/result', [SearchController::class, 'search'])->name('search.result');
Route::post('/search/add/{githubId}', [SearchController::class, 'addToFavorites'])->name('search.add');
Route::post('/search/remove/{githubId}', [SearchController::class, 'removeFromFavorites'])->name('search.remove');

Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/remove/{githubId}', [FavoriteController::class, 'remove'])->name('favorites.remove');
