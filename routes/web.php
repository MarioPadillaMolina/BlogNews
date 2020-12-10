<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontendController;


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

Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/show/{post}', [FrontendController::class, 'show'])->name('frontend.show');
Route::get('/author/{id}', [FrontendController::class, 'author'])->name('frontend.author');
Route::post('/store', [FrontendController::class, 'store'])->name('frontend.store');

Auth::routes(['register' => false]);

//Ruta cambiada por defecto en App\Providers\RouteServiceProviders
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//backend
Route::resource('/posts', PostController::class)->middleware('auth'); //protejo las rutas de backend de usuarios no autenticados
Route::resource('/comments', CommentController::class)->middleware('auth');



//fallback
Route::fallback([FrontendController::class, 'fallback'])->name('fallback');

