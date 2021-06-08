<?php

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/buscar', [HomeController::class, 'search'])->name('receta.search');;

Route::resource('receta', RecipeController::class, ['except' => [
    'index'
]]);

Route::delete('/receta/{id}', [RecipeController::class, 'destroy'])->name('receta.destroy');
Route::put('/receta/{id}', [RecipeController::class, 'update'])->name('receta.update');
Route::get('/receta/{slug}', [RecipeController::class, 'show'])->name('receta.show');
Route::get('/receta/{slug}/edit', [RecipeController::class, 'edit'])->name('receta.edit');
Route::post('/receta/{id}/vote-up', [RecipeController::class, 'vote_up'])->name('receta.vote-up');
Route::post('/receta/{id}/vote-down', [RecipeController::class, 'vote_down'])->name('receta.vote-down');
Route::get('/receta/{id}/hide', [RecipeController::class, 'hide'])->name('receta.hide');
Route::post('/receta/{slug}/{image_id}/delete', [RecipeController::class, 'destroy_recipe_image'])->name('recipe.destroy_image');

Route::get('/perfil/{nickname}', [ProfileController::class, 'index'])->name('perfil.index');
Route::get('/perfil/{nickname}/recetas', [ProfileController::class, 'show'])->name('perfil.show');
Route::get('/perfil/{nickname}/edit', [ProfileController::class, 'edit'])->name('perfil.edit');
Route::put('/perfil/{nickname}', [ProfileController::class, 'update'])->name('perfil.update');

Route::get('/blogs', [HomeController::class, 'index']);
Auth::routes();


Route::get('login/social/{provider}', [LoginController::class, 'redirectToProvider'])->name('login.social');
Route::get('login/social/callback/{provider}', [LoginController::class, 'handleProviderCallback']);

Route::post('/receta/comment', [CommentController::class, 'store'])->name('comment.store');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/carpetasupersecreta', [BotController::class, 'gestionar']);
Route::get('/recetobot', [BotController::class, 'recetobot'])->name('recetobot');