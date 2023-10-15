<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(
    // ['middleware' => ['auth', 'auth.type:super-admin,admin'], // This if you want to use the normal users table with the roles column that has user types.
    ['middleware' => ['auth:admin'],
    'prefix' => 'admin'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');

    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');

    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

    Route::get('dashboard/profile/edit', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');

    Route::patch('dashboard/profile/edit', [ProfileController::class, 'update'])->name('dashboard.profile.update');

    Route::resource('dashboard/categories', CategoriesController::class);
    Route::resource('dashboard/products', ProductsController::class);
});

