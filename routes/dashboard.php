<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');

    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');

    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

    Route::resource('dashboard/categories', CategoriesController::class);
});

