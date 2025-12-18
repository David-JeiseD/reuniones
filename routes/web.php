<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DniController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MeetingController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/consulta-dni/{dni}', [DniController::class, 'obtenerDatos']);

Route::get('/completar-perfil', [App\Http\Controllers\UserController::class, 'showCompletarPerfil'])->name('perfil.completar');
Route::post('/completar-perfil', [App\Http\Controllers\UserController::class, 'storeCompletarPerfil'])->name('perfil.guardar');


Route::post('/asistencia/entrada', [AttendanceController::class, 'marcarEntrada'])->name('asistencia.entrada');
Route::post('/asistencia/salida', [AttendanceController::class, 'marcarSalida'])->name('asistencia.salida');
Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
Route::post('/perfil/actualizar', [UserController::class, 'actualizarPerfil'])->name('perfil.actualizar');
Route::get('/admin/historial-general', [AdminController::class, 'historialGeneral'])->name('admin.historial');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard de Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // CRUD de Reuniones
    Route::resource('meetings', MeetingController::class);
    
    // Reporte de Asistencia de una reunión específica
    Route::get('/meetings/{meeting}/asistencias', [AdminController::class, 'verAsistencias'])->name('admin.meetings.asistencias');

    Route::resource('ugels', App\Http\Controllers\Admin\UgelController::class)->only(['index', 'store', 'destroy']);

    Route::get('/meetings/{meeting}/pdf', [AdminController::class, 'generarPDF'])->name('admin.meetings.pdf');
});