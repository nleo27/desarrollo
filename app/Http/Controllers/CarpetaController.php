<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carpeta;

class CarpetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carpeta = Carpeta::whereNull('carpeta_padre_id')->get();
        return view('admin.mi_unidad.index', ['carpetas'=>$carpeta]);
    }

    /**
     * Show the form for creating a new resource.
     */
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
        $carpeta->modulo = $request->modulo;
        $carpeta->estante = $request->estante;
        $carpeta->codigo = $request->codigo;
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
        return view('admin.mi_unidad.show', compact('carpeta', 'subcarpetas'));
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
    public function update(Request $request, string $id)
    {
        //
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
        $carpeta->carpeta_padre_id = $request->carpeta_padre_id;
        $carpeta->modulo = $request->modulo;
        $carpeta->estante = $request->estante;
        $carpeta->codigo = $request->codigo;
        $carpeta->descipcion = $request->descripcion;
        $carpeta->save();

        toastr()->success('Se creo la Subcarpeta corectamente', 'Notificación');

        return redirect()->back();
    }
}
