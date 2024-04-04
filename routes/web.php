<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
});

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/medic/panel',[MedicController::class, 'index'])->name('medic/panel');
    Route::get('/admin/panel',[AdminController::class, 'index'])->name('admin/panel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';