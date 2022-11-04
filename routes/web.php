<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [PagesController::class,'index']);
Route::get('/about', [PagesController::class,'about']);
Route::get('/services', [PagesController::class,'services']);

Route::resource('posts',PostsController::class);
Route::get('/posts/{id}/summary',[PostsController::class, 'summarize']);
Route::get('/posts/{id}/ideas',[PostsController::class, 'extract']);
Route::get('/posts/{id}/generateimage',[PostsController::class, 'generateimage']);


require __DIR__.'/auth.php';

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

