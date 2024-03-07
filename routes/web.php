<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('dashboard2',[DashboardController::class,'dashboard2'])->name('dashboard2');

    Route::get('dashboard-sale-information',[DashboardController::class,'dashboardSaleInformation'])->name('dashboard_sale_information');
});

Route::middleware('auth')->group(function () {

//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('cash',[CommonController::class, 'cash'])->name('cash');
    Route::get('get-products-json',[CommonController::class, 'productsJson'])->name('get_products_json');
    Route::get('get-sale-products-json',[CommonController::class, 'saleProductsJson'])->name('get_sale_products_json');
    Route::get('get-product-info',[CommonController::class, 'productInfoJson'])->name('get_product_info');
    Route::get('get-batch-products-json',[CommonController::class, 'batchProductsJson'])->name('get_batch_products_json');
    Route::get('get-account-code-json',[CommonController::class, 'accountCodeJson'])->name('get_account_code_json');
    Route::get('get-account-opening-code-json',[CommonController::class, 'accountOpeningCodeJson'])->name('get_opening_account_code_json');
    Route::get('get-account-subtype-json',[CommonController::class, 'accountSubtypeJson'])->name('get_subtype_list');
    Route::get('get-customers-json',[CommonController::class, 'customersJson'])->name('get_customers_json');
    Route::get('get-suppliers-json',[CommonController::class, 'suppliersJson'])->name('get_suppliers_json');
       Route::get('get-client-json', [CommonController::class,'clientJson'])->name('client_json');


});

require __DIR__.'/auth.php';
Route::get('cache-clear', function () {

    Artisan::call('cache:forget spatie.permission.cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";

});
