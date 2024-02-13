<?php

use Modules\Account\Http\Controllers\AccountController;
use Modules\Account\Http\Controllers\SubAccountController;
use Modules\Account\Http\Controllers\FinancialYearController;
use Modules\Account\Http\Controllers\ChartOfAccountController;
use Modules\Account\Http\Controllers\DebitVoucherController;
use Modules\Account\Http\Controllers\CreditVoucherController;
use Modules\Account\Http\Controllers\ContraVoucherController;
use Modules\Account\Http\Controllers\JournalVoucherController;
use Modules\Account\Http\Controllers\OpeningBalanceController;
use Modules\Account\Http\Controllers\ExpenseController;
use Modules\Account\Http\Controllers\AccountHeadTypeController;
use Modules\Account\Http\Controllers\AccountHeadSubTypeController;

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


Route::prefix('account')->middleware('auth')->name('account.')->group(function() {

    //Account head
    Route::get('all-account-head-type', [AccountHeadTypeController::class, 'index'])->name('account_head_type_all');
    Route::get('all-account-head-type/datatable', [AccountHeadTypeController::class, 'datatable'])->name('account_head_type_datatable');
    Route::get('add-account-head-type', [AccountHeadTypeController::class, 'create'])->name('account_head_type_add');
    Route::post('add-account-head-type', [AccountHeadTypeController::class, 'store']);
    Route::get('edit-account-head-type/{accountHeadType}', [AccountHeadTypeController::class, 'edit'])->name('account_head_type_edit');
    Route::post('edit-account-head-type/{accountHeadType}', [AccountHeadTypeController::class, 'update']);

    //Account head
    Route::get('all-account-sub-head', [AccountHeadSubTypeController::class, 'index'])->name('account_sub_head_all');
    Route::get('all-account-sub-head/datatable', [AccountHeadSubTypeController::class, 'datatable'])->name('account_sub_head_datatable');
    Route::get('add-account-sub-head', [AccountHeadSubTypeController::class, 'create'])->name('account_sub_head_add');
    Route::post('add-account-sub-head', [AccountHeadSubTypeController::class, 'store']);
    Route::get('edit-account-sub-head/{accountHeadSubType}', [AccountHeadSubTypeController::class, 'edit'])->name('account_sub_head_edit');
    Route::post('edit-account-sub-head/{accountHeadSubType}', [AccountHeadSubTypeController::class, 'update']);


    // Chart of Account
    Route::get('chart-of-account', [ChartOfAccountController::class,'chartOfAccount'])->name('chart_of_account');
    //Sub Account
    Route::get('subaccount-list', [SubAccountController::class,'index'])->name('sub_account_all');
    Route::get('subaccount/datatable', [SubAccountController::class,'datatable'])->name('sub_account_datatable');
    Route::get('add-subaccount', [SubAccountController::class,'add'])->name('sub_account_add');
    Route::post('add-subaccount', [SubAccountController::class,'addPost']);
    Route::get('edit-subaccount/{accSubCode}', [SubAccountController::class,'edit'])->name('sub_account_edit');
    Route::post('edit-subaccount/{accSubCode}', [SubAccountController::class,'editPost']);

    //Financial Year
    Route::get('financialyear-list', [FinancialYearController::class,'index'])->name('financialyear_all');
    Route::get('financialyear/datatable', [FinancialYearController::class,'datatable'])->name('financialyear_datatable');
    Route::get('add-financialyear', [FinancialYearController::class,'add'])->name('financialyear_add');
    Route::post('add-financialyear', [FinancialYearController::class,'addPost']);
    Route::get('edit-financialyear/{financialYear}', [FinancialYearController::class,'edit'])->name('financialyear_edit');
    Route::post('edit-financialyear/{financialYear}', [FinancialYearController::class,'editPost']);

    Route::get('predefined-accounts', [AccountController::class,'predefineAccounts'])->name('predefined_accounts');
    Route::post('predefined-accounts-add', [AccountController::class,'predefineAccountsAdd'])->name('predefined_accounts_add');

    Route::get('opening-balance', [OpeningBalanceController::class,'index'])->name('opening_balance');
    Route::get('opening-balance/datatable', [OpeningBalanceController::class,'datatable'])->name('opening_balance_datatable');
    Route::get('add-opening-balance', [OpeningBalanceController::class,'add'])->name('opening_balance_add');
    Route::post('add-opening-balance', [OpeningBalanceController::class,'addPost']);
    Route::get('edit-opening-balance/{accVoucher}', [OpeningBalanceController::class,'edit'])->name('opening_balance_edit');
    Route::post('edit-opening-balance/{accVoucher}', [OpeningBalanceController::class,'editPost']);

    Route::get('debit-voucher', [DebitVoucherController::class,'index'])->name('debit_voucher');
    Route::get('debit-voucher/datatable', [DebitVoucherController::class,'datatable'])->name('debit_voucher_datatable');
    Route::get('add-debit-voucher', [DebitVoucherController::class,'add'])->name('debit_voucher_add');
    Route::post('add-debit-voucher', [DebitVoucherController::class,'addPost']);
    Route::get('edit-debit-voucher/{accVoucher}', [DebitVoucherController::class,'edit'])->name('debit_voucher_edit');
    Route::post('edit-debit-voucher/{accVoucher}', [DebitVoucherController::class,'editPost']);
    Route::get('view-debit-voucher', [DebitVoucherController::class,'VoucherView'])->name('debit_voucher_view');

    Route::get('credit-voucher', [CreditVoucherController::class,'index'])->name('credit_voucher');
    Route::get('credit-voucher/datatable', [CreditVoucherController::class,'datatable'])->name('credit_voucher_datatable');
    Route::get('add-credit-voucher', [CreditVoucherController::class,'add'])->name('credit_voucher_add');
    Route::post('add-credit-voucher', [CreditVoucherController::class,'addPost']);
    Route::get('edit-credit-voucher/{accVoucher}', [CreditVoucherController::class,'edit'])->name('credit_voucher_edit');
    Route::post('edit-credit-voucher/{accVoucher}', [CreditVoucherController::class,'editPost']);
    Route::get('view-credit-voucher', [CreditVoucherController::class,'VoucherView'])->name('credit_voucher_view');

    Route::get('contra-voucher', [ContraVoucherController::class,'index'])->name('contra_voucher');
    Route::get('contra-voucher/datatable', [ContraVoucherController::class,'datatable'])->name('contra_voucher_datatable');
    Route::get('add-contra-voucher', [ContraVoucherController::class,'add'])->name('contra_voucher_add');
    Route::post('add-contra-voucher', [ContraVoucherController::class,'addPost']);
    Route::get('edit-contra-voucher/{accVoucher}', [ContraVoucherController::class,'edit'])->name('contra_voucher_edit');
    Route::post('edit-contra-voucher/{accVoucher}', [ContraVoucherController::class,'editPost']);
    Route::get('view-contra-voucher', [ContraVoucherController::class,'VoucherView'])->name('contra_voucher_view');

    Route::get('journal-voucher', [JournalVoucherController::class,'index'])->name('journal_voucher');
    Route::get('journal-voucher/datatable', [JournalVoucherController::class,'datatable'])->name('journal_voucher_datatable');
    Route::get('add-journal-voucher', [JournalVoucherController::class,'add'])->name('journal_voucher_add');
    Route::post('add-journal-voucher', [JournalVoucherController::class,'addPost']);
    Route::get('edit-journal-voucher/{accVoucher}', [JournalVoucherController::class,'edit'])->name('journal_voucher_edit');
    Route::post('edit-journal-voucher/{accVoucher}', [JournalVoucherController::class,'editPost']);
    Route::get('view-journal-voucher', [JournalVoucherController::class,'VoucherView'])->name('journal_voucher_view');

    Route::get('bank-reconciliation', [AccountController::class,'index'])->name('bank_reconciliation');
    Route::get('add-payment-method', [AccountController::class,'index'])->name('add_payment_method');
    Route::get('payment-method-list', [AccountController::class,'index'])->name('payment_method_list');

    Route::get('supplier-payment', [AccountController::class,'supplierPaymentAdd'])->name('supplier_payment');
    Route::post('supplier-payment', [AccountController::class,'supplierPaymentAddPost']);
    Route::get('supplier-due-list', [AccountController::class,'supplierDueList'])->name('get_supplier_voucher_due_list');
    Route::get('supplier-voucher-details', [AccountController::class,'supplierVoucherDetail'])->name('get_supplier_voucher_details');

    Route::get('customer-receive', [AccountController::class,'customerReceiveAdd'])->name('customer_receive');
    Route::post('customer-receive', [AccountController::class,'customerReceiveAddPost']);
    Route::get('customer-due-list', [AccountController::class,'customerDueList'])->name('get_voucher_due_list');
    Route::get('customer-voucher-details', [AccountController::class,'customerVoucherDetail'])->name('get_voucher_details');

    Route::get('service-payment', [AccountController::class,'index'])->name('service_payment');
    Route::get('cash-adjustment', [AccountController::class,'index'])->name('cash_adjustment');
    Route::get('voucher-approval', [AccountController::class,'index'])->name('voucher_approval');

    //Expense
    Route::get('expense-item', [ExpenseController::class,'index'])->name('expense_item_all');
    Route::get('expense-item/datatable', [ExpenseController::class,'datatable'])->name('expense_item_datatable');
    Route::get('add-expense-item', [ExpenseController::class,'add'])->name('expense_item_add');
    Route::post('add-expense-item', [ExpenseController::class,'addPost']);
    Route::get('edit-expense-item/{expenseItem}', [ExpenseController::class,'edit'])->name('expense_item_edit');
    Route::post('edit-expense-item/{expenseItem}', [ExpenseController::class,'editPost']);

    //Expense add
    Route::get('expense', [ExpenseController::class,'expense'])->name('expense_all');
    Route::get('expense/datatable', [ExpenseController::class,'expenseDatatable'])->name('expense_datatable');
    Route::get('add-expense', [ExpenseController::class,'expenseAdd'])->name('expense_add');
    Route::post('add-expense', [ExpenseController::class,'expenseAddPost']);


});
