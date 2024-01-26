<?php

use Illuminate\Support\Facades\Route;
use Modules\Loan\Http\Controllers\LoanController;
use Modules\Loan\Http\Controllers\LoanDetailController;
use Modules\Loan\Http\Controllers\LoanHolderController;

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

Route::prefix('loan')->middleware('auth')->name('loan.')->group(function () {

    // Loan Holder
    Route::get('loan-holder-index', [LoanHolderController::class, 'index'])->name('loan_holder_index');
    Route::get('loan-holder-create', [LoanHolderController::class, 'create'])->name('loan_holder_create');
    Route::post('loan-holder-create', [LoanHolderController::class, 'store']);
    Route::get('loan-holder-edit/{loanHolder}', [LoanHolderController::class, 'edit'])->name('loan_holder_edit');
    Route::post('loan-holder-edit/{loanHolder}', [LoanHolderController::class, 'update']);
    Route::get('loan-holder-index/datatable', [LoanHolderController::class, 'datatable'])->name('loan_holder_datatable');

    Route::get('index', [LoanController::class, 'index'])->name('index');
    Route::get('create', [LoanController::class, 'create'])->name('create');
    Route::post('create', [LoanController::class, 'store']);
    Route::get('edit/{loan}', [LoanController::class, 'edit'])->name('edit');
    Route::post('edit/{loan}', [LoanController::class, 'update']);
    Route::get('loan/datatable', [LoanController::class, 'loanDatatable'])->name('loan_datatable');
    Route::post('loan-payment', [LoanController::class,'loanPayment'])->name('loan_payment');
    Route::prefix('details')->middleware('auth')->name('details.')->group(function () {
    Route::get('/{loan}/index', [LoanDetailController::class, 'index'])->name('index');
    Route::get('/{loan}/details_datatable', [LoanDetailController::class, 'detailsDatatable'])->name('details_datatable');

    Route::post('/payment-store', [LoanDetailController::class, 'paymentStore'])->name('payment.store');


    });
});
