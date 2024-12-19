<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta;

class NotificacionController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Obtener todas las notificaciones del usuario autenticado
        $notificaciones = $usuario->notifications;

        // Obtener todas las cartas dirigidas al usuario autenticado
        $cartas = Carta::where('dirigido', $usuario->id)->get();

        // Retornar la vista con ambas variables
        return view('notificaciones.index', compact('notificaciones', 'cartas'));
    }
}
