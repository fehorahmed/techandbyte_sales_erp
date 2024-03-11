<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;

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



Route::prefix('report')->middleware('auth')->name('report.')->group(function () {
    // Warehouse
    Route::get('purchase', [ReportController::class, 'purchase'])->name('purchase');
    Route::get('sale', [ReportController::class, 'sale'])->name('sale');
    Route::get('party-ledger', [ReportController::class,'partyLedger'])->name('party_ledger');
    Route::get('supplier-statement', [ReportController::class,'supplierStatement'])->name('supplier_statement');

     //Vat
    Route::get('vat-payment', [ReportController::class,'vatPayment'])->name('vat_payment');
    Route::get('vat-register', [ReportController::class,'vatRegister'])->name('vat_register');
    Route::get('vat-certificate-6.6', [ReportController::class,'vatCertificateSixPointSix'])->name('vat_certificate_six_point_six');
    Route::post('vat-payout', [ReportController::class,'vatPayout'])->name('vat_payout');

    //AIT
    Route::get('ait-payment', [ReportController::class,'aitPayment'])->name('ait_payment');
    Route::get('ait-register', [ReportController::class,'aitRegister'])->name('ait_register');
    Route::get('ait-chalan', [ReportController::class,'aitChalan'])->name('ait_chalan');
    Route::post('ait-payout', [ReportController::class,'aitPayout'])->name('ait_payout');

});
