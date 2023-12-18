<?php
use Modules\Bank\Http\Controllers\BankController;
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

Route::prefix('bank')->middleware('auth')->name('bank.')->group(function() {
    // Bank
    Route::get('all-bank', [BankController::class,'index'])->name('bank_all');
    Route::get('all-bank/datatable', [BankController::class,'datatable'])->name('bank_datatable');
    Route::get('add-bank', [BankController::class,'add'])->name('bank_add');
    Route::post('add-bank', [BankController::class,'addPost']);
    Route::get('edit-bank/{bank}', [BankController::class,'edit'])->name('bank_edit');
    Route::post('edit-bank/{bank}', [BankController::class,'editPost']);
});
