<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\TwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

    Route::resource('cart', CartController::class);

    Route::get('checkout', [OrdersController::class, 'create'])->name('checkout.create');
    Route::post('checkout', [OrdersController::class, 'store'])->name('checkout.store');

    Route::get('user/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('two-factor');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
