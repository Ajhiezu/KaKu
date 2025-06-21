<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
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