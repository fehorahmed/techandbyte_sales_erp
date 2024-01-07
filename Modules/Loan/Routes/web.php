<?php

use Illuminate\Support\Facades\Route;
use Modules\Loan\Http\Controllers\LoanController;
use Modules\Loan\Http\Controllers\LoanDetailController;

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

    Route::get('index', [LoanController::class, 'index'])->name('index');
    Route::get('create', [LoanController::class, 'create'])->name('create');
    Route::post('create', [LoanController::class, 'store']);
    Route::get('edit/{loan}', [LoanController::class, 'edit'])->name('edit');
    Route::post('edit/{loan}', [LoanController::class, 'update']);
    Route::get('loan/datatable', [LoanController::class, 'loanDatatable'])->name('loan_datatable');
    Route::prefix('details')->middleware('auth')->name('details.')->group(function () {
        Route::get('/{loan}/index', [LoanDetailController::class, 'index'])->name('index');
        Route::get('/{loan}/details_datatable', [LoanDetailController::class, 'detailsDatatable'])->name('details_datatable');

        Route::post('/payment-store', [LoanDetailController::class, 'paymentStore'])->name('payment.store');
    });
});
