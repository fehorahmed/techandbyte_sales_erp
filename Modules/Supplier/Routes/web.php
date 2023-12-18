<?php

use Modules\Supplier\Http\Controllers\SupplierController;

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

Route::prefix('supplier')->middleware('auth')->name('supplier.')->group(function() {
    // Supplier
    Route::get('all-supplier', [SupplierController::class,'index'])->name('supplier_all');
    Route::get('all-supplier/datatable', [SupplierController::class,'datatable'])->name('supplier_datatable');
    Route::get('add-supplier', [SupplierController::class,'add'])->name('supplier_add');
    Route::post('add-supplier', [SupplierController::class,'addPost']);
    Route::get('edit-supplier/{supplier}', [SupplierController::class,'edit'])->name('supplier_edit');
    Route::post('edit-supplier/{supplier}', [SupplierController::class,'editPost']);
    Route::post('add-ajax-supplier', [SupplierController::class,'addAjaxPost'])->name('add_ajax_supplier');
});
