<?php

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

// Route::get('/', function () {
//     return view('login');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth:web'], function () {

    Route::get('/', [App\Http\Controllers\PostController::class, 'index']);

    Route::post('/posts/store', [App\Http\Controllers\PostController::class, 'save_post'])->name('save-post');

    Route::post('/posts/store-comment', [App\Http\Controllers\PostController::class, 'save_comment'])->name('save-comment');
});