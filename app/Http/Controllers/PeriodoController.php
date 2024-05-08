<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\Periodo;
use Illuminate\Support\Facades\File;


use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    // Método para mostrar el formulario de creación de periodo
    public function create()
    {
        $periodos = Periodo::all();

        return view('create-periodo', compact('periodos'));
    }

    // Método para guardar el nuevo periodo
    public function create2(Request $request)
    {
        // Verificar si el nombre del periodo ya existe en la base de datos
        $nombre_periodo_existente = Periodo::where('nombre', $request->nombre_periodo)->exists();
        if ($nombre_periodo_existente) {
            toastr()->error('El nombre del periodo ya existe.', 'Error');
            return redirect()->back();
        }

        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Verificar que la fecha inicial no sea mayor que la fecha final
        if ($fecha_inicio > $fecha_fin) {
            toastr()->error('La fecha de inicio no puede ser mayor que la fecha de fin.', 'Error');
            return redirect()->back();
        }

        // Verificar si las fechas se superponen con otro periodo existente
        $periodo_superpuesto = Periodo::where(function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                ->orWhereBetween('fecha_fin', [$fecha_inicio, $fecha_fin])
                ->orWhere(function ($query) use ($fecha_inicio, $fecha_fin) {
                    $query->where('fecha_inicio', '<', $fecha_inicio)
                        ->where('fecha_fin', '>', $fecha_fin);
                });
        })->exists();

        if ($periodo_superpuesto) {
            toastr()->error('Las fechas del periodo se superponen con otro periodo existente.', 'Error');
            return redirect()->back();
        }
        
        
        // Validaciones
        $request->validate([
            'nombre_periodo' => [
                'required',
                Rule::unique('periodos', 'nombre')->ignore($request->id),
            ],
            'descripcion_periodo' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

  
        // Crear el nuevo periodo
        Periodo::create([
            'nombre' => $request->input('nombre_periodo'),
            'descripcion' => $request->input('descripcion_periodo'),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'periodo_activo' => $request->has('periodo_activo') ? 1 : 0,
        ]);

        // Crear la carpeta para el nuevo periodo en storage/app/public/
        /*$nombrePeriodo = $request->input('nombre_periodo');
        $rutaCarpeta = storage_path('app/public/' . $nombrePeriodo);

        if (!File::exists($rutaCarpeta)) {
            File::makeDirectory($rutaCarpeta);
        }*/

        toastr()->success('Periodo registrado correctamente', 'Éxito');

        return redirect()->route('create_periodo');
    }

    public function seleccionarPeriodo($id)
    {
        // Guardar el ID del periodo seleccionado en la sesión
        Session::put('periodo_seleccionado', $id);
        
        // Redireccionar a la página de documentos
        return redirect()->route('documento.crear', ['id' => $id]);
    }
}
