<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Controllers\ClientCategoryController;
use Modules\Client\Http\Controllers\ClientController;


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

Route::prefix('client')->middleware('auth')->name('client.')->group(function () {
    // Client Category
    Route::get('index', [ClientController::class, 'index'])->name('index');
    Route::get('create', [ClientController::class, 'create'])->name('create');
    Route::post('create', [ClientController::class, 'store'])->name('store');
    Route::get('edit/{client}', [ClientController::class, 'edit'])->name('edit');
    Route::post('edit/{client}', [ClientController::class, 'update'])->name('update');
    Route::get('index/datatable', [ClientController::class, 'datatable'])->name('client_datatable');
});

Route::prefix('client-category')->middleware('auth')->name('client.')->group(function () {
    // Client Category
    Route::get('index', [ClientCategoryController::class, 'index'])->name('category.index');
    Route::get('create', [ClientCategoryController::class, 'create'])->name('category.create');
    Route::post('create', [ClientCategoryController::class, 'store'])->name('category.store');
    Route::get('edit/{client_category}', [ClientCategoryController::class, 'edit'])->name('category.edit');
    Route::post('edit/{client_category}', [ClientCategoryController::class, 'update'])->name('category.update');
    Route::get('index/datatable', [ClientCategoryController::class, 'datatable'])->name('client_category_datatable');

    Route::post('add-ajax-customer', [ClientController::class, 'addAjaxPost'])->name('add_ajax_client');
});
