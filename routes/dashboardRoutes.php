<?php

use App\Http\Middleware\DemoMode;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserType;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CkeditorController;



Route::middleware([CheckUserType::class, DemoMode::class])->group(function(){
   
   //Dashboard routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/crm-home', [HomeController::class, 'crm_index'])->name('crm.home');
    Route::get('/accounts-home', [HomeController::class, 'accounts_index'])->name('accounts.home');
    Route::get('/inventory-home', [HomeController::class, 'inventory_dashboard'])->name('inventory.home');
});