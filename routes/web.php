<?php

use App\Http\Controllers\ArchivoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreateUsuarioController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\RegistroUsuario;
use App\Http\Controllers\CarpetaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\GrupoAreaController;
use App\Http\Controllers\ArchivoGrupoController;
use Illuminate\Support\Facades\Auth;

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
    Route::put('/areas/{id}', [AreasController::class, 'update'])->name('areas.update');
    Route::delete('/areas/{id}', [AreasController::class, 'destroy'])->name('areas.destroy');
    Route::get('/usuarios/{id}/edit', [CreateUsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [CreateUsuarioController::class, 'update'])->name('usuarios.update');
    Route::get('/admin/mi_unidad', [CarpetaController::class, 'index'])->name('mi_unidad.index');
    Route::post('/admin/mi_unidad', [CarpetaController::class, 'store'])->name('mi_unidad.store');
    Route::get('/admin/mi_unidad/carpeta/{id}', [CarpetaController::class, 'show'])->name('mi_unidad.carpeta');
    Route::get('/admin/mi_unidad/carpeta', [CarpetaController::class, 'crear_subcarpeta'])->name('mi_unidad.carpeta.crear_subcarpeta');
    Route::put('/admin/mi_unidad', [CarpetaController::class, 'update'])->name('mi_unidad.update');

    Route::get('/archivo-grupo', [ArchivoGrupoController::class, 'create'])->name('archivo-grupo.create');

    Route::get('/archivo-grupo/getArchivos', [ArchivoGrupoController::class, 'getArchivos'])->name('archivo-grupo.getArchivos');

    //RUTAS PARA ARCHIVOS
   

    Route::post('/admin/mi_unidad/upload-and-create', [ArchivoController::class, 'uploadAndCreate'])->name('mi_unidad.archivo.uploadAndCreate');
    Route::get('/admin/mi_unidad/carpeta/{id}/archivos', [ArchivoController::class, 'getArchivos'])->name('archivos');

    //ruta para cambair archivo de forma privada a publico
    Route::post('/admin/mi_unidad/carpeta', [ArchivoController::class, 'cambiar_de_privado_a_publico'])->name('mi_unidad.archivo.cambiar.privado.publico');


    //RUTA DE CREAR GRUPO
    Route::get('/create-grupo', [GrupoController::class, 'create'])->name('create.grupo');

    Route::post('/crear-grupo', [GrupoController::class, 'creacionGrupo'])->name('grupos.creacion');

    Route::post('/guardar-areas', [GrupoAreaController::class, 'guardarAreas'])->name('guardar_areas');

    Route::post('eliminar-area', [GrupoAreaController::class, 'quitarArea'])->name('eliminar_area');
    
   
});

 //RUTA PARA MOSTRAR ARCHIVOS PRIVADOS

 Route::get('storage/{carpeta}/{archivo}', function($carpeta, $archivo){

    if (Auth::check()) {
        $path =storage_path('app'.DIRECTORY_SEPARATOR. $carpeta .DIRECTORY_SEPARATOR. $archivo);
        return response()->file($path);
    }else{
        abort(403, 'No tiene permiso para acceder a este archivo');
    }

    
})->name('mostrar.archivos.privados');




