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
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

// Index
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/buscar', [HomeController::class, 'search'])->name('receta.search');;

// Recipe
Route::resource('receta', RecipeController::class)->only(['create']);
Route::get('/receta/{slug}', [RecipeController::class, 'show'])->name('receta.show');
Route::post('/receta', [RecipeController::class, 'store'])->name('receta.store')->middleware('auth');
Route::get('/receta/{slug}/edit', [RecipeController::class, 'edit'])->name('receta.edit')->middleware('auth');
Route::put('/receta/{id}', [RecipeController::class, 'update'])->name('receta.update')->middleware('auth');
Route::delete('/receta/{id}', [RecipeController::class, 'destroy'])->name('receta.destroy')->middleware('auth');
Route::post('/receta/{slug}/{image_id}/delete', [RecipeController::class, 'destroy_recipe_image'])->name('recipe.destroy_image');
Route::get('/receta/{id}/hide', [RecipeController::class, 'hide'])->name('receta.hide');
Route::post('/receta/{id}/vote-up', [RecipeController::class, 'vote_up'])->name('receta.vote-up');
Route::post('/receta/{id}/vote-down', [RecipeController::class, 'vote_down'])->name('receta.vote-down');
// Comment
Route::post('/receta/comment', [CommentController::class, 'store'])->name('comment.store');

// Profile
Route::get('/perfil/{nickname}', [ProfileController::class, 'index'])->name('perfil.index');
Route::get('/perfil/{nickname}/recetas', [ProfileController::class, 'show'])->name('perfil.show');
Route::get('/perfil/{nickname}/edit', [ProfileController::class, 'edit'])->name('perfil.edit');
Route::put('/perfil/{nickname}', [ProfileController::class, 'update'])->name('perfil.update');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('login/social/{provider}', [LoginController::class, 'redirectToProvider'])->name('login.social');
Route::get('login/social/callback/{provider}', [LoginController::class, 'handleProviderCallback']);

// Telegram
Route::match(['get', 'post'], '/carpetasupersecreta', [BotController::class, 'gestionar']);
Route::get('/recetobot', [BotController::class, 'recetobot'])->name('recetobot');

//Static
Route::get('/privacidad', function(){
    return view('static.privacity');
});
Route::get('/coockies', function(){
    return view('static.coockies');
});