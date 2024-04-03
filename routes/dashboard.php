<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    // ['middleware' => ['auth', 'auth.type:super-admin,admin'], // This if you want to use the normal users table with the roles column that has user types.
    [
        'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'prefix' => 'admin', LaravelLocalization::setLocale()
    ],
    function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->prefix(LaravelLocalization::setLocale());

        Route::get('dashboard/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');

        Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');

        Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

        Route::get('dashboard/profile/edit', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');

        Route::patch('dashboard/profile/edit', [ProfileController::class, 'update'])->name('dashboard.profile.update');

        Route::resource('dashboard/categories', CategoriesController::class);
        Route::resource('dashboard/products', ProductsController::class);

        Route::get('dashboard/create-slider', [ProductsController::class, 'createSlider'])->name('slider.create');
        Route::post('dashboard/create-slider', [ProductsController::class, 'storeSlider'])->name('slider.store');

        // These Routes of Spatie Package.
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    }
);
