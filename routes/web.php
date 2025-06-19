<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

//Login
Route::get('/login',[AdminController::class,'index'])->name('login');
Route::post('/login',[AdminController::class,'login']);
Route::post('/logout',[AdminController::class,'logout'])->name('logout');


Route::get('/dashboard',function (){
    return view('dashboard');
})->middleware('auth');



//Product
