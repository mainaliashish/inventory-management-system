<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::apiResource('/employee', EmployeeController::class);
Route::apiResource('/supplier', SupplierController::class);
Route::apiResource('/category', CategoryController::class);
Route::apiResource('/product', ProductController::class);
Route::apiResource('/expense', ExpenseController::class);
Route::apiResource('/salary', SalaryController::class);
Route::apiResource('/customer', CustomerController::class);
Route::post('/salary/paid/{id}', [SalaryController::class, 'paid'])->name('salary.paid');
Route::get('/salary/view/{id}', [SalaryController::class, 'view'])->name('salary.view');
Route::get('/edit-salary/{id}', [SalaryController::class, 'editSalary'])->name('salary.edit');
Route::put('/update-salary/{id}', [SalaryController::class, 'updateSalary'])->name('salary.update');
Route::put('/stock/update/{id}', [ProductController::class, 'updateStock'])->name('stock.update');
Route::get('/get/subproduct/{id}', [PosController::class, 'getProduct'])->name('product.get');