<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/admin/product', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/product/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/product', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/product/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/product/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/product/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
