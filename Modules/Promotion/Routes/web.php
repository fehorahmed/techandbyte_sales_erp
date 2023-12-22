<?php

use Illuminate\Support\Facades\Route;
use Modules\Promotion\Http\Controllers\PromotionController;

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


Route::prefix('promotion')->middleware('auth')->name('promotion.')->group(function () {
    // Client Category
    Route::get('index', [PromotionController::class, 'index'])->name('index');
    Route::get('create', [PromotionController::class, 'create'])->name('create');
    Route::post('create', [PromotionController::class, 'store'])->name('store');
    Route::get('edit/{promotion}', [PromotionController::class, 'edit'])->name('edit');
    Route::post('edit/{promotion}', [PromotionController::class, 'update'])->name('update');
    Route::get('index/datatable', [PromotionController::class, 'datatable'])->name('promotion_datatable');
});
