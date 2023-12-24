<?php

use Modules\Product\Http\Controllers\BrandController;
use Modules\Product\Http\Controllers\UnitController;
use Modules\Product\Http\Controllers\CategoryController;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\SubCategoryController;
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

Route::prefix('product')->middleware('auth')->name('product.')->group(function () {
    Route::get('/', 'ProductController@index');

    //Unit
    Route::get('all-unit', [UnitController::class, 'index'])->name('unit_all');
    Route::get('all-unit/datatable', [UnitController::class, 'datatable'])->name('unit_datatable');
    Route::get('add-unit', [UnitController::class, 'add'])->name('unit_add');
    Route::post('add-unit', [UnitController::class, 'addPost']);
    Route::get('edit-unit/{unit}', [UnitController::class, 'edit'])->name('unit_edit');
    Route::post('edit-unit/{unit}', [UnitController::class, 'editPost']);

    //Brand
    Route::get('all-brand', [BrandController::class, 'index'])->name('brand_all');
    Route::get('all-brand/datatable', [BrandController::class, 'datatable'])->name('brand_datatable');
    Route::get('add-brand', [BrandController::class, 'create'])->name('brand_add');
    Route::post('add-brand', [BrandController::class, 'store']);
    Route::get('edit-brand/{brand}', [BrandController::class, 'edit'])->name('brand_edit');
    Route::post('edit-brand/{brand}', [BrandController::class, 'update']);


    //Category
    Route::get('all-category', [CategoryController::class, 'index'])->name('category_all');
    Route::get('all-category/datatable', [CategoryController::class, 'datatable'])->name('category_datatable');
    Route::get('add-category', [CategoryController::class, 'add'])->name('category_add');
    Route::post('add-category', [CategoryController::class, 'addPost']);
    Route::get('edit-category/{category}', [CategoryController::class, 'edit'])->name('category_edit');
    Route::post('edit-category/{category}', [CategoryController::class, 'editPost']);

    //Category
    Route::get('all-sub-category', [SubCategoryController::class, 'index'])->name('sub_category_all');
    Route::get('all-sub-category/datatable', [SubCategoryController::class, 'datatable'])->name('sub_category_datatable');
    Route::get('add-sub-category', [SubCategoryController::class, 'add'])->name('sub_category_add');
    Route::post('add-sub-category', [SubCategoryController::class, 'addPost']);
    Route::get('edit-sub-category/{subCategory}', [SubCategoryController::class, 'edit'])->name('sub_category_edit');
    Route::post('edit-sub-category/{subCategory}', [SubCategoryController::class, 'editPost']);

    //Category
    Route::get('all-product', [ProductController::class, 'index'])->name('product_all');
    Route::get('all-product/datatable', [ProductController::class, 'datatable'])->name('product_datatable');
    Route::get('add-product', [ProductController::class, 'add'])->name('product_add');
    Route::post('add-product', [ProductController::class, 'addPost']);
    Route::get('edit-product/{product}', [ProductController::class, 'edit'])->name('product_edit');
    Route::post('edit-product/{product}', [ProductController::class, 'editPost']);
    Route::get('get-product-sub-category', [ProductController::class, 'getSubCategory'])->name('get_sub_category');
});
