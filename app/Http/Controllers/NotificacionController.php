<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
    $usuario = auth()->user();

    // Obtener todas las notificaciones del usuario autenticado
    $notificaciones = $usuario->notifications; // Esto obtiene todas las notificaciones

    // O filtrar solo las no leídas
    // $notificaciones = $usuario->unreadNotifications;

    // Depurar las notificaciones
    

    return view('notificaciones.index', compact('notificaciones'));
    }
}
