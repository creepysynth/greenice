<?php

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/', [SearchController::class, 'index'])->name('search.index');
Route::get('/search', [SearchController::class, 'search'])->name('search.begin');

Route::get('/gh', function () {
    //$response = \Illuminate\Support\Facades\Http::get("https://api.github.com/search/repositories?q=green+in:name+green+in:description+user:creepysynth");

    $response = \Illuminate\Support\Facades\Http::get("https://api.github.com/search/repositories?q=language:php+greenice+in:name");

    dd($response->json());
});
