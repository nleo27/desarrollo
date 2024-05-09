<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use App\Models\Area;

class GrupoController extends Controller
{
    public function create()
        {
            $grupos = Grupo::all();
            $areas = Area::all();
            return view('create-grupo', compact('grupos', 'areas'));
        }

    public function creacionGrupo(Request $request)
        {
            // Validar los datos del formulario
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:255',
            ]);

            // Crear un nuevo grupo
            $grupo = new Grupo();
            $grupo->nombre = $request->nombre;
            $grupo->descripcion = $request->descripcion;
            $grupo->save();

            toastr()->success('Grupo Creado Exitosamente', 'Notificacion');

            // Redirecciona a la página de áreas
            return back();
        }
}
