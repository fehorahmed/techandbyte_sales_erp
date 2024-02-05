<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\InventoryController;

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

//Route::group([], function () {
//    Route::resource('inventory', InventoryController::class)->names('inventory');
//});

Route::prefix('inventory')->middleware('auth')->name('inventory.')->group(function() {

    // Inventory

    Route::get('inventory-receipt', [InventoryController::class,'inventoryReceipt'])->name('inventory_receipt_all');
    Route::get('inventory-receipt/datatable', [InventoryController::class,'inventoryReceiptDatatable'])->name('inventory_receipt_datatable');
    Route::get('inventory-receipt/details/{inventoryOrder}', [InventoryController::class,'inventoryReceiptDetails'])->name('inventory_receipt_details');

});
