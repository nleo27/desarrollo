<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateUsuarioController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\PeriodoController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Nueva ruta para la creación de usuarios
Route::get('/create-usuario', [CreateUsuarioController::class, 'index'])->name('create_usuario');
Route::get('/create-area', [AreasController::class, 'index'])->name('create_area');
Route::post('/create-area', [AreasController::class, 'store'])->name('areas.store');
Route::get('/create-periodo', [PeriodoController::class, 'create'])->name('create_periodo');
Route::post('/create-periodo', [PeriodoController::class, 'create2'])->name('periodo.create2');
Route::get('/seleccionar-periodo/{id}', [PeriodoController::class, 'seleccionarPeriodo'])->name('seleccionar-periodo');



