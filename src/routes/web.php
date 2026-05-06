<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.edit');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

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
    Route::get('/mypage', [App\Http\Controllers\ProfileController::class, 'show'])->name('mypage');
    Route::get('/mypage/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/sell', [App\Http\Controllers\SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [App\Http\Controllers\SellController::class, 'store'])->name('sell.store');
});