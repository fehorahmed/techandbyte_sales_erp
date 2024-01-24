<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\Http\Controllers\TaskController;

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

// Route::group([], function () {
//     Route::resource('task', TaskController::class)->names('task');
// });

Route::prefix('task')->middleware('auth')->name('task.')->group(function () {
    // Supplier
    Route::get('all-task', [TaskController::class, 'index'])->name('task_all');
    Route::get('all-task/datatable', [TaskController::class, 'datatable'])->name('task_datatable');
    Route::get('add-task', [TaskController::class, 'create'])->name('task_add');
    Route::post('add-task', [TaskController::class, 'store']);
    Route::get('edit-task/{task}', [TaskController::class, 'edit'])->name('task_edit');
    Route::post('edit-task/{task}', [TaskController::class, 'editPost']);
});
