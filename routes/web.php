<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateUsuarioController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\RegistroUsuario;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas protegidas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/create-usuario', [CreateUsuarioController::class, 'index'])->name('create_usuario');
    Route::get('/create-area', [AreasController::class, 'index'])->name('create_area');
    Route::post('/create-area', [AreasController::class, 'store'])->name('areas.store');
    Route::get('/create-periodo', [PeriodoController::class, 'create'])->name('create_periodo');
    Route::post('/create-periodo', [PeriodoController::class, 'create2'])->name('periodo.create2');
    Route::get('/seleccionar-periodo/{id}', [PeriodoController::class, 'seleccionarPeriodo'])->name('seleccionar-periodo');
    Route::get('/documento/{id}', [DocumentoController::class, 'crear'])->name('documento.crear');
    Route::post('/usuarios', [RegistroUsuario::class, 'store'])->name('usuarios.store');
    Route::get('/areas/{id}/edit', [AreasController::class, 'edit'])->name('areas.edit');
    Route::put('/areas/{id}', 'AreasController@update')->name('areas.update');
});




