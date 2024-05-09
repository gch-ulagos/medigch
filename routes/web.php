<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\filesController;


Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/medic/panel',[MedicController::class, 'index'])->name('medic/panel');
    Route::get('/medic/panel',[MedicController::class, 'crear_orden'])->name('medic/panel/crear_orden');
    Route::post('/medic/panel',[MedicController::class, 'store'])->name('medic/panel/crear_orden/store');

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
    Route::post('/admin/crear_personal',[AdminController::class, 'store'])->name('/admin/crear_personal/store');
});


#ruta prueba de archivos
Route::get('subirarchivo',[filesController::class, 'crear_orden'])
->name('/subirarchivo');
Route::post('subirarchivo',[filesController::class, 'store'])
->name('/subirarchivo/store');
require __DIR__.'/auth.php';
