<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Login
Route::get('/login',[AdminController::class,'index'])->name('login');
Route::post('/login',[AdminController::class,'login']);
Route::post('/logout',[AdminController::class,'logout'])->name('logout');


Route::get('/',function (){
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Product
Route::resource('products',ProductController::class);

// Category
Route::resource('categories',CategoryController::class);

// Customer
Route::resource('customers',CustomerController::class);

// User
Route::resource('users',UserController::class);

// Sale
Route::get('/sale',[AdminController::class,'sales'])->name('sales');
// routes/web.php
Route::post('/transactions', [AdminController::class, 'transaction'])->name('transactions.store');
// Untuk autocomplete by barcode
Route::get('/autocomplete/barcode', function (\Illuminate\Http\Request $request) {
    $results = \App\Models\Product::where('barcode', 'like', '%' . $request->barcode . '%')
        ->limit(10)
        ->get(['id', 'barcode', 'name', 'selling_price','stock']);

    return response()->json($results);
});

// Untuk autocomplete by name
Route::get('/autocomplete/product', function (\Illuminate\Http\Request $request) {
    $results = \App\Models\Product::where('name', 'like', '%' . $request->name . '%')
        ->limit(10)
        ->get(['id', 'barcode', 'name', 'selling_price','stock']);

    return response()->json($results);
});
Route::get('/autocomplete/customer', function (\Illuminate\Http\Request $request) {
    $results = \App\Models\Customer::where('name', 'like', '%' . $request->name . '%')
        ->limit(10)->get();

    return response()->json($results);
});

Route::post('/debt', [AdminController::class, 'debt'])->name('debts.store');

//debt
Route::resource('debts',DebtController::class);
Route::get('/report-debt',[DebtController::class,'report'])->name('report.debt');
Route::get('debts/{customer_id}/history', [DebtController::class, 'history'])->name('debts.history');

//report sale
Route::get('/reports/sales', [AdminController::class, 'report_sales'])->name('sales.report');
Route::get('/reports/sales/{transaction}', [AdminController::class, 'show_detail_sales'])->name('sales.history');


