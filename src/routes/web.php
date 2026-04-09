<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
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



Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');

Route::post('/item/{item_id}/like', [LikeController::class, 'store'])->middleware('auth')->name('likes.store');

Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');