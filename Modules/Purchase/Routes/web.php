<?php
use Modules\Purchase\Http\Controllers\PurchaseController;
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


Route::prefix('purchase')->middleware('auth')->name('purchase.')->group(function() {

    // Purchase
    Route::get('add-purchase', [PurchaseController::class,'addPurchase'])->name('purchase_add');
    Route::post('add-purchase', [PurchaseController::class,'addPurchasePost']);
    Route::get('purchase-receipt', [PurchaseController::class,'purchaseReceipt'])->name('purchase_receipt_all');
    Route::get('purchase-receipt/datatable', [PurchaseController::class,'purchaseReceiptDatatable'])->name('purchase_receipt_datatable');
    Route::get('purchase-receipt/details/{productPurchase}', [PurchaseController::class,'purchaseReceiptDetails'])->name('purchase_receipt_details');


});
