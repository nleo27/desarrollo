<?php

namespace App\Http\Controllers;
use App\Models\DetalleRequerimiento;
use Illuminate\Support\Facades\Storage;
use App\Models\Requerimiento;

use Illuminate\Http\Request;
use App\Models\Carta;

class NotificacionController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();
        $detalleRequerimiento = DetalleRequerimiento::all();

        // Obtener todas las notificaciones del usuario autenticado
        $notificaciones = $usuario->notifications;

        // Obtener todas las cartas dirigidas al usuario autenticado
        $cartas = Carta::where('dirigido', $usuario->id)->get();

        // Obtener todos los requerimientos asociados a esas cartas
        $requerimientos = Requerimiento::whereIn('id_carta', $cartas->pluck('id'))->get();

        // Obtener el primer archivo asociado a cada requerimiento
        $archivos = $requerimientos->map(function ($requerimiento) {
            return DetalleRequerimiento::where('id_requerimiento', $requerimiento->id)->first();
        })->filter(); // Filtrar nulos en caso de que no haya archivos.

            // Retornar la vista con ambas variables
            return view('notificaciones.index', compact('notificaciones', 'cartas', 'archivos'));
    }



}
