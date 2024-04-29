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
        return view('admin.mi_unidad.index');
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

        toastr()->success('Registro ingresado', 'Notificación');

        return redirect()->route('mi_unidad.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
