<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleRequerimiento;
use Illuminate\Support\Facades\Storage;

class RequerimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function subirArchivo(Request $request, $id)
            {
                // Validación de los datos del archivo
                $request->validate([
                    'archivo' => 'required|file|mimes:pdf,doc,docx|max:2048',
                    'observaciones' => 'nullable|string',
                ]);

                // Verificar si ya existe un archivo para este requerimiento
                $detalleRequerimiento = DetalleRequerimiento::where('id_requerimiento', $id)->first();

                // Si ya existe un archivo
                if ($detalleRequerimiento) {
                    // Eliminar el archivo anterior si existe
                    if (Storage::exists('public/' . $detalleRequerimiento->archivo)) {
                        Storage::delete('public/' . $detalleRequerimiento->archivo);
                    }

                    // Subir el nuevo archivo
                    $archivo = $request->file('archivo');
                    $rutaArchivo = $archivo->store('archivos_requerimientos', 'public');

                    // Actualizar el detalle del requerimiento con el nuevo archivo
                    $detalleRequerimiento->update([
                        'archivo' => $rutaArchivo,
                        'observaciones' => $request->input('observaciones'),
                    ]);

                    return response()->json(['mensaje' => 'Archivo actualizado exitosamente.']);
                } else {
                    // Si no existe archivo, creamos uno nuevo
                    if ($request->hasFile('archivo')) {
                        $archivo = $request->file('archivo');
                        $rutaArchivo = $archivo->store('archivos_requerimientos', 'public');

                        // Crear un nuevo detalle para el requerimiento
                        DetalleRequerimiento::create([
                            'id_requerimiento' => $id,
                            'archivo' => $rutaArchivo,
                            'observaciones' => $request->input('observaciones'),
                        ]);

                        return response()->json(['mensaje' => 'Archivo subido exitosamente.']);
                    }

                    return response()->json(['mensaje' => 'No se pudo subir el archivo.'], 400);
                }
            }

    
        public function verificarArchivo($id)
            {
                // Verificar si ya existe un archivo para el requerimiento
                $detalleRequerimiento = DetalleRequerimiento::where('id_requerimiento', $id)->first();

                // Retornar una respuesta JSON que indique si ya existe un archivo
                if ($detalleRequerimiento) {
                    return response()->json(['hasFile' => true]); // Existe un archivo
                } else {
                    return response()->json(['hasFile' => false]); // No existe archivo
                }
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
