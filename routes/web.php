<?php

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;

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
// Route::get('/home', function () {
//     return redirect('/');
// });

Route::get('/', [HomeController::class, 'index']);

Route::resource('receta', RecipeController::class, ['except' => [
    'index'
]]);

Route::post('/receta/{id}/vote-up', [RecipeController::class, 'vote_up'])->name('receta.vote-up');
Route::post('/receta/{id}/vote-down', [RecipeController::class, 'vote_down'])->name('receta.vote-down');

Route::get('/perfil/{nickname}', [ProfileController::class, 'index'])->name('perfil.index');
Route::get('/perfil/{nickname}/recetas', [ProfileController::class, 'show'])->name('perfil.show');
Route::get('/perfil/{nickname}/edit', [ProfileController::class, 'edit'])->name('perfil.edit');
Route::put('/perfil/{nickname}', [ProfileController::class, 'update'])->name('perfil.update');

Route::get('/blogs', [HomeController::class, 'index']);
Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
