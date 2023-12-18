<?php
use Modules\Sale\Http\Controllers\SaleController;
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


Route::prefix('sale')->middleware('auth')->name('sale.')->group(function() {
    // Sale
    Route::get('add-sale', [SaleController::class,'addSale'])->name('sale_add');
    Route::post('add-sale', [SaleController::class,'addSalePost']);
    Route::get('sale-receipt', [SaleController::class,'saleReceipt'])->name('sale_receipt_all');
    Route::get('sale-receipt/datatable', [SaleController::class,'saleReceiptDatatable'])->name('sale_receipt_datatable');
    Route::get('sale-receipt/details/{invoice}', [SaleController::class,'saleReceiptDetails'])->name('sale_receipt_details');
});;
