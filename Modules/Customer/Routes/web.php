<?php

use Modules\Customer\Http\Controllers\CustomerController;

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

Route::prefix('customer')->middleware('auth')->name('customer.')->group(function() {
    // Customer
    Route::get('all-customer', [CustomerController::class,'index'])->name('customer_all');
    Route::get('all-customer/datatable', [CustomerController::class,'datatable'])->name('customer_datatable');
    Route::get('add-customer', [CustomerController::class,'add'])->name('customer_add');
    Route::post('add-customer', [CustomerController::class,'addPost']);
    Route::get('edit-customer/{customer}', [CustomerController::class,'edit'])->name('customer_edit');
    Route::post('edit-customer/{customer}', [CustomerController::class,'editPost']);
    Route::post('add-ajax-customer', [CustomerController::class,'addAjaxPost'])->name('add_ajax_customer');
});
