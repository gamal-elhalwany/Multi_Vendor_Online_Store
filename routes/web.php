<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CurrencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\TwoFactorAuthenticationController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PayPalController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/', [HomeController::class, 'index'])->name('home')->prefix(LaravelLocalization::setLocale())->middleware('localeSessionRedirect', 'localizationRedirect', 'localeViewPath');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

    // Categories Routes.
    Route::get('category/{category}', [HomeController::class, 'category'])->name('front.category');

    Route::resource('cart', CartController::class);

    Route::get('checkout', [OrdersController::class, 'create'])->name('checkout.create');
    Route::post('checkout', [OrdersController::class, 'store'])->name('checkout.store');

    Route::get('user/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('two-factor');

    Route::post('change-currency', [CurrencyController::class, 'exchange_currency'])->name('currency.convert');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Socialite Routes.
Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.socialite.callback');

// Paypal Routes.
Route::get('payments/paypal/{order}', [PayPalController::class, 'create'])->name('paypal.create');
Route::get('payments/paypal/{order}/return', [PayPalController::class, 'callback'])->name('paypal.return');
Route::get('payments/paypal/{order}/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

//Payments Routes.
// Route::post('payments', [PaymentController::class, 'pay'])->name('payments.pay');
// Route::get('success', [PaymentController::class, 'success'])->name('success');
// Route::get('cancel', [PaymentController::class, 'cancel'])->name('cancel');

// require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
