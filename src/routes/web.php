<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
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

Route::middleware('auth')->group(function () {
    Route::get('purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create');
    Route::post('purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store');
    Route::get('purchase/address/{item}', [PurchaseController::class, 'editAddress'])
        ->name('purchase.editAddress');
    Route::post('purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
        ->name('purchase.updateAddress');
    Route::post('purchase/payment/{item}', [PurchaseController::class, 'updatePayment'])
        ->name('purchase.updatePayment');

    Route::get(
        'purchase/success/{item}',
        [PurchaseController::class, 'success']
    )
        ->name('purchase.success');

    Route::get(
        'purchase/cancel/{item}',
        [PurchaseController::class, 'cancel']
    )
        ->name('purchase.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/mypage/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/sell', [App\Http\Controllers\SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [App\Http\Controllers\SellController::class, 'store'])->name('sell.store');
});