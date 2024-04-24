<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\Periodo;

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

        // Verificar si las fechas se superponen con otro periodo existente
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
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
