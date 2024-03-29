<?php

use Illuminate\Support\Facades\Route;
use Modules\Warehouse\Http\Controllers\WarehouseController;

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



Route::prefix('warehouse')->middleware('auth')->name('warehouse.')->group(function () {
    // Warehouse
    Route::get('all-warehouse', [WarehouseController::class, 'index'])->name('index');
    Route::get('all-warehouse/datatable', [WarehouseController::class, 'datatable'])->name('warehouse_datatable');
    Route::get('add-warehouse', [WarehouseController::class, 'create'])->name('create');
    Route::post('add-warehouse', [WarehouseController::class, 'store']);
    Route::get('edit-warehouse/{warehouse}', [WarehouseController::class, 'edit'])->name('edit');
    Route::post('edit-warehouse/{warehouse}', [WarehouseController::class, 'update']);
    Route::post('add-ajax-warehouse', [WarehouseController::class, 'addAjaxPost'])->name('add_ajax_warehouse');
});
