<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/medic/panel',[MedicController::class, 'index'])->name('medic/panel');
    Route::get('/medic/panel',[MedicController::class, 'crear_orden'])->name('medic/panel/crear_orden');

    Route::get('/admin/panel',[AdminController::class, 'index'])->name('admin/panel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

#Rutas del admin
Route::middleware('auth')->group(function(){
    Route::get('/admin/crear_personal',[AdminController::class, 'crear_personal'])->name('/admin/crear_personal');
    Route::post('/admin/crear_personal',[AdminController::class, 'store'])->name('/admin/crear_personal');
});

require __DIR__.'/auth.php';
