<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::prefix('/service')->group(function(){
    Route::get('/',[ServiceController::class,'index'])->name('service.index');
    Route::get('/create',[ServiceController::class,'create'])->name('service.create');
    Route::post('/store',[ServiceController::class,'store'])->name('service.store');
    Route::get('/product/change/color',[ServiceController::class,'getProductColors'])->name('getProductColors');
    Route::get('/get/district',[ServiceController::class,'getDistricts'])->name('getDistricts');
    Route::get('/fetch',[ServiceController::class,'fetch'])->name('service.fetch');
    Route::get('/edit/{id}',[ServiceController::class,'edit'])->name('service.edit');
    Route::post('/update',[ServiceController::class,'update'])->name('service.update');
});