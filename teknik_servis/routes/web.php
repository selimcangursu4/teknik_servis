<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SmsLogController;


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
    Route::post('/priority/request',[ServiceController::class,'priorityRequest'])->name('service.priorityRequest');
    Route::post('/invoice/update',[ServiceController::class,'updateWarrantyStatus'])->name('service.updateWarrantyStatus');
    Route::post('/check-imei',[ServiceController::class,'checkImei'])->name('checkImei');
    Route::post('/getWarrantyAndInvoice',[ServiceController::class,'getWarrantyAndInvoice'])->name('getWarrantyAndInvoice');
    Route::post('/delete',[ServiceController::class,'delete'])->name('service.delete');
    Route::post('/get/processing',[ServiceController::class,'getProcessed'])->name('service.getProcessed');
    Route::post('/take/control',[ServiceController::class,'takeControl'])->name('service.takeControl');
    Route::post('/control/checked',[ServiceController::class,'controlChecked'])->name('service.controlChecked');
    Route::post('/take/delivery',[ServiceController::class,'takeDelivery'])->name('service.takeDelivery');
    Route::post('/create/payment',[ServiceController::class,'createPayment'])->name('service.createPayment');
    Route::post('/cancel/payment',[ServiceController::class,'cancelPayment'])->name('service.cancelPayment');
    Route::post('/no-fault',[ServiceController::class,'noFault'])->name('service.noFault');
});

// Sms Gönder
Route::post('/sms/send',[SmsLogController::class,'send'])->name('sms.send');