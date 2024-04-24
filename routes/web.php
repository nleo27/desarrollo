<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateUsuarioController;
use App\Http\Controllers\AreasController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Nueva ruta para la creación de usuarios
Route::get('/create-usuario', [CreateUsuarioController::class, 'index'])->name('create_usuario');
Route::get('/create-area', [AreasController::class, 'index'])->name('create_area');
Route::post('/create-area', [AreasController::class, 'store'])->name('areas.store');

