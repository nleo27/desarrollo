<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area; 
use Flash;

class AreasController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('create-area', compact('areas'));
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255|unique:areas',
            'descripcion' => 'nullable|string|max:255',
        ]);

        // Crea una nueva área en la base de datos
        Area::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        toastr()->success('Registro ingresado', 'Notificacion');

        // Redirecciona de vuelta a la página de áreas
        return redirect()->route('areas.store');
    }
}
