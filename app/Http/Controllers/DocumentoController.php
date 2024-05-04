<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function crear($id)
    {
        // Guardar el ID del periodo seleccionado en la sesión
        Session::put('periodo_seleccionado', $id);

        return view('documento', ['periodoId' => $id]);
    }
}
