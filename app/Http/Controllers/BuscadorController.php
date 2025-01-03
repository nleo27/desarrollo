<?php

namespace App\Http\Controllers;
use App\Models\Periodo;
use App\Models\Carpeta;
use App\Models\Archivo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuscadorController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $role = $user->roles->first()->name;
    
    // Obtener el periodo activo
    $periodoActivo = Periodo::where('periodo_activo', 1)->first();

    // Si el usuario es Administrador, obtener todas las carpetas del periodo activo
    if ($role == 'Administrador') {
        // Obtener las carpetas asociadas al periodo activo
        $carpetas = Carpeta::where('id_periodo', $periodoActivo->id)->get();
    } else {
        // Si el usuario no es Administrador, obtener las carpetas de su área y asociadas al periodo activo
        $carpetas = Carpeta::where('user_id', $user->id) // Filtrar por el usuario autenticado
                           ->where('id_periodo', $periodoActivo->id) // Filtrar por el periodo activo
                           ->get();
    }

    // Obtener los archivos de esas carpetas
    $archivos = [];
    foreach ($carpetas as $carpeta) {
        $archivos[] = Archivo::where('carpeta_id', $carpeta->id)->get();
    }

    // Pasar los archivos a la vista
    $periodos = Periodo::all(); // Esto es para el select de periodos
    return view('create-buscador', compact('periodos', 'role', 'archivos'));
}

    public function obtenerArchivos(Request $request)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();
        
        // Obtener el primer rol del usuario
        $role = $user->roles->first()->name;
        
        // Obtener el periodo seleccionado desde la solicitud
        $periodoId = $request->input('periodo');
        
        // Si el usuario es Administrador
        if ($role == 'Administrador') {
            // Si no se ha seleccionado un periodo, se usa el periodo activo
            if (!$periodoId) {
                // Obtener el periodo activo por defecto
                $periodoId = Periodo::where('periodo_activo', 1)->first()->id;
            }
    
            // Obtener las carpetas relacionadas con el periodo seleccionado
            $carpetas = Carpeta::where('id_periodo', $periodoId)->get();
        } else {
            // Si el usuario no es Administrador, solo puede ver carpetas de su área y el periodo activo
            $periodoActivo = Periodo::where('periodo_activo', 1)->first()->id;
    
            // Obtener las carpetas filtradas por usuario, área y periodo activo
            $carpetas = Carpeta::where('user_id', $user->id) // Filtrar por el usuario autenticado
                ->where('id_area', $user->id_area) // Filtrar por el área del usuario
                ->where('id_periodo', $periodoActivo) // Filtrar por el periodo activo
                ->get();
        }
    
        // Obtener los archivos de esas carpetas en una sola colección plana
        $archivos = Archivo::whereIn('carpeta_id', $carpetas->pluck('id'))->get();
    
        // Log para ver los archivos
        logger()->info('Archivos obtenidos: ', $archivos->toArray());
    
        // Retorna los archivos como respuesta JSON
        return response()->json($archivos);
    }
}
