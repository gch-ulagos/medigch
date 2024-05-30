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
    Route::get('/medic/panel/crear_orden',[MedicController::class, 'crear_orden'])->name('medic/panel/crear_orden');
    Route::post('/medic/panel/crear_orden/store',[MedicController::class, 'ordenStore'])->name('medic/panel/crear_orden/store');
    Route::get('/medic/panel/adjuntar_doc',[filesController::class, 'adjuntar_doc'])->name('medic/panel/adjuntar_doc');
    Route::post('/medic/panel/adjuntar_doc/store',[filesController::class, 'documentStore'])->name('medic/panel/adjuntar_doc/store');

    Route::get('/admin/panel',[AdminController::class, 'index'])->name('admin/panel');
});

Route::patch('/admin/orden/{id}', [AdminController::class, 'updateOrden'])->name('admin.updateOrden');

Route::middleware('auth')->group(function () {
    Route::get('/file/download/{documento}', [filesController::class, 'downloadFile'])->name('file/download');
});

Route::middleware('auth')->group(function () {
    Route::get('/user/panel',[UserController::class, 'index'])->name('user/panel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

#Rutas del admin
Route::middleware('auth')->group(function(){
    Route::get('/admin/crear_personal',[AdminController::class, 'crear_personal'])->name('/admin/crear_personal');
    Route::post('/admin/crear_personal',[AdminController::class, 'store'])->name('/admin/crear_personal/store');
    Route::get('/admin/modificar_orden',[AdminController::class, 'getOrdenes'])->name('/admin/modificar_ordenes');
    Route::get('/api/ordenes/{id}', [AdminController::class, 'ordenInfo']);
    Route::patch('/admin/orden/{id}/update', [AdminController::class, 'updateOrden'])->name('admin.modificar_ordenes.update');
});

require __DIR__.'/auth.php';
