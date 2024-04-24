<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\Periodo;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function create()
    {
        return view('create-periodo');
    }

    public function create2(Request $request)
    {
        // Validaciones
    $request->validate([
        'nombre_periodo' => [
            'required',
            Rule::unique('periodos', 'nombre')
        ],
        'descripcion_periodo' => 'required',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

        // Verificar si hay un periodo activo y desactivarlo si es necesario
        if ($request->has('periodo_activo')) {
            Periodo::where('periodo_activo', true)->update(['periodo_activo' => false]);
        }

        
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Convertir las fechas al formato esperado por la base de datos
        $fecha_inicio_bd = Carbon::createFromFormat('d/m/Y', $fecha_inicio)->format('Y-m-d');
        $fecha_fin_bd = Carbon::createFromFormat('d/m/Y', $fecha_fin)->format('Y-m-d');

        
        // Verificar que la fecha inicial no sea mayor que la fecha final
        if ($fecha_inicio > $fecha_fin) {
            
            toastr()->error('No se puede registrar las fechas.', 'Error');
            return redirect()->back();
        }


            // Verificar si las fechas se superponen con otro periodo existente
            $periodo_superpuesto = Periodo::where(function ($query) use ($fecha_inicio_bd, $fecha_fin_bd) {
                $query->whereBetween('fecha_inicio', [$fecha_inicio_bd, $fecha_fin_bd])
                    ->orWhereBetween('fecha_fin', [$fecha_inicio_bd, $fecha_fin_bd])
                    ->orWhere(function ($query) use ($fecha_inicio_bd, $fecha_fin_bd) {
                        $query->where('fecha_inicio', '<', $fecha_inicio_bd)
                                ->where('fecha_fin', '>', $fecha_fin_bd);
                    });
            })->exists();

            if ($periodo_superpuesto) {
                toastr()->error('Las fechas del periodo se superponen con otro periodo existente.', 'Error');
                return redirect()->back();
            }

            // Imprimir mensajes de error en la consola para depuración
            dd('Fecha de inicio:', $fecha_inicio, 'Fecha de fin:', $fecha_fin, 'Fecha inicio BD:', $fecha_inicio_bd, 'Fecha fin BD:', $fecha_fin_bd, 'Periodo superpuesto:', $periodo_superpuesto);

        // Crear el nuevo periodo
        Periodo::create([
            'nombre' => $request->input('nombre_periodo'),
            'descripcion' => $request->input('descripcion_periodo'),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'activo' => $request->has('periodo_activo'),
        ]);

        return redirect()->route('periodo.create2');
    }
}
