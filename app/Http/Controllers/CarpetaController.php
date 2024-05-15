<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carpeta;
use Illuminate\Support\Facades\Auth;
use App\Models\Periodo;
use App\Models\Area;

class CarpetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = Auth::user()->id;

        // Obtener el área del usuario si está asignada
        $area_usuario = Auth::user()->area;

        // Obtener solo los periodos activos
        $periodos = Periodo::where('periodo_activo', 1)->get();

        // Verificar si el usuario tiene un área asignada
        if ($area_usuario) {
            // Obtener solo las carpetas que pertenecen al usuario, en el área específica y en el período activo
            $carpetas = Carpeta::where('user_id', $id_user)
                        ->whereIn('id_periodo', $periodos->pluck('id')) // Filtrar por los IDs de los periodos activos
                        ->where('id_area', $area_usuario->id) // Filtrar por el ID del área del usuario
                        ->whereNull('carpeta_padre_id')
                        ->get();

            // Listar solo el área del usuario
            $areas = [$area_usuario];
        } else {
            // Si el usuario no tiene un área asignada, no mostrar ninguna carpeta
            $carpetas = [];
            $areas = [];
        }

        return view('admin.mi_unidad.index', compact('carpetas', 'periodos', 'areas'));
    }

   
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191',
            'modulo' => 'nullable|max:191',
            'estante' => 'nullable|max:191',
            'codigo' => 'nullable|max:191',
            'descipcion' => 'nullable|max:191',
            
            
        ]);

        $carpeta = new Carpeta();
        $carpeta->nombre = $request->nombre;
        $carpeta->user_id = $request->user_id;
        $carpeta->modulo = $request->modulo;
        $carpeta->estante = $request->estante;
        $carpeta->codigo = $request->codigo;
        $carpeta->id_periodo = $request->periodo_id;
        $carpeta->id_area = $request->area_id;
        $carpeta->descipcion = $request->descripcion;
        $carpeta->save();

        toastr()->success('Se creo la carpeta corectamente', 'Notificación');

        return redirect()->route('mi_unidad.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $carpeta =Carpeta::findOrFail($id);
        $subcarpetas = $carpeta->carpetasHijas;
        $archivos = $carpeta->archivos;
        // Obtener el área del usuario si está asignada
        $area_usuario = Auth::user()->area;

        // Obtener solo los periodos activos
        $periodos = Periodo::where('periodo_activo', 1)->get();
        // Listar solo el área del usuario
        $areas = [$area_usuario];
        return view('admin.mi_unidad.show', compact('carpeta', 'subcarpetas', 'archivos', 'periodos', 'areas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //$datos = request()->all();
       // return response()->json($datos);

       if(empty($request->nombre)) {
        toastr()->error('El campo nombre no puede estar vacío. Por favor ingrese un nombre válido.', 'Error');
        return redirect()->back()->withInput();
    }
       
       $request->validate([
        'nombre' => 'required|max:191',
        'modulo' => 'nullable|max:191',
        'estante' => 'nullable|max:191',
        'codigo' => 'nullable|max:191',
        'descipcion' => 'nullable|max:191',
   
        ], [
            'nombre.required' => 'El campo nombre no puede estar vacío. Por favor ingrese un nombre válido.',
        ]);

        // Verificar si el nombre de la carpeta está vacío
   

        $id= $request->id;
        $carpeta = Carpeta::find($id);
        $carpeta->nombre = $request->nombre;
        $carpeta->modulo = $request->modulo;
        $carpeta->estante = $request->estante;
        $carpeta->codigo = $request->codigo;
        $carpeta->id_periodo = $request->periodo_id;
        $carpeta->id_area = $request->area_id;
        $carpeta->descipcion = $request->descripcion;
        $carpeta->save();

        toastr()->success('Se actualizó corectamente', 'Notificación');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function crear_subcarpeta(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191',
            'carpeta_padre_id' => 'required',
            'modulo' => 'nullable|max:191',
            'estante' => 'nullable|max:191',
            'codigo' => 'nullable|max:191',
            'descipcion' => 'nullable|max:191',
            
            
        ]);

        $carpeta = new Carpeta();
        $carpeta->nombre = $request->nombre;
        $carpeta->user_id = $request->user_id;
        $carpeta->carpeta_padre_id = $request->carpeta_padre_id;
        $carpeta->modulo = $request->modulo;
        $carpeta->estante = $request->estante;
        $carpeta->codigo = $request->codigo;
        $carpeta->id_periodo = $request->periodo_id;
        $carpeta->id_area = $request->area_id;
        $carpeta->descipcion = $request->descripcion;
        $carpeta->save();

        toastr()->success('Se creo la Subcarpeta corectamente', 'Notificación');

        return redirect()->back();
    }
}
