<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area; 
use Toastr;

class AreasController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('create-area', compact('areas'));
    }

    public function store(Request $request)
    {
       
         // Valida si el nombre del área ya existe en la base de datos
         $existingArea = Area::where('nombre', $request->nombre)->first();
         if ($existingArea) {
            toastr()->error('No se puede registrar el área porque ya existe.', 'Error');
             
             return redirect()->route('areas.store');
         }
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

