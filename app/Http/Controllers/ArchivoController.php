<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function uploadAndCreate(Request $request){
        $id = $request->id;
        
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time().'-'.$file->getClientOriginalName();
            $file->storeAs($id, $fileName, 'public');
        
            $archivo = new Archivo();
            $archivo->carpeta_id = $id;
            $archivo->nombre = $fileName;        
            $archivo->nombre_archivo = $request->nombre_archivo;
            $archivo->folio = $request->folios;
            $archivo->personal_dirigido = $request->personal_dirigido;
            $archivo->ubicacion = $request->ubicacion;
            $archivo->descripcion = $request->descripcion;
        
            $archivo->save();
        }
    
        return redirect()->back();
    }
  

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
