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

        /**
         * Muestra el formulario de edición de un área.
         *
         * @param  int  $id
         * @return \Illuminate\View\View
         */
        public function edit($id)
            {
                $area = Area::findOrFail($id);
                return view('edit-area', compact('area'));
            }


         public function update(Request $request, $id)
            {

                // Verifica si hay otra área con el mismo nombre
                $existingArea = Area::where('nombre', $request->nombre)
                                    ->where('id', '<>', $id) // Excluye el área actual
                                    ->first();

                if ($existingArea) {
                    toastr()->error('Ya existe un área con ese nombre.', 'Error');
                    return back()->withInput();
                }

                // Valida los datos del formulario de edición
                $request->validate([
                    'nombre' => 'required|string|max:255|unique:areas,nombre,' . $id,
                    'descripcion' => 'nullable|string|max:255',
                ]);

                

                // Busca el área por su ID y actualiza los datos
                $area = Area::findOrFail($id);
                $area->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                ]);

                toastr()->success('Área actualizada correctamente', 'Notificación');

                // Redirecciona a la página de áreas
                return back();
            }

            public function destroy($id)
            {
                $area = Area::findOrFail($id);
                
                // Desvincula a los usuarios de esta área
                
                 $area->usuarios()->update(['area_id' => null]);
                
                // Elimina el área
                $area->delete();
            
                toastr()->success('Área eliminada correctamente', 'Notificación');
            
                return back();
            }

}



