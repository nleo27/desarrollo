<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Carpeta;
use Yajra\DataTables\Facades\DataTables;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function uploadAndCreate(Request $request){
        
         // Mensajes de error personalizados
        $messages = [
            'upload.*.required' => 'El archivo es requerido.',
            'upload.*.file' => 'El archivo debe ser un archivo válido.',
            'upload.*.mimes' => 'El archivo debe ser de tipo: jpg, png, jpeg, docx, doc, xlsx, pdf.',
            'upload.*.max' => 'El tamaño máximo del archivo es de 3MB.',
            'upload.max' => 'Solo se pueden subir máximo 5 archivos a la vez.',
        ];
        
         // Validación de los archivos
            $validator = Validator::make($request->all(), [
                'upload.*' => 'required|file|mimes:jpg,png,jpeg,docx,doc,xlsx,pdf|max:3072', // 3072 KB = 3 MB
                'upload' => 'max:5',
            ], $messages);
            
        // Comprobar si la validación falla
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->back()->withInput();
        }
    
        $carpetaId = $request->carpeta_padre_id;
    
        foreach ($request->file('upload') as $file) {
            if ($file->isValid()) {
                $fileName = time() . '-' . $file->getClientOriginalName();
    
                /*Crear la carpeta si no existe de forma public
                $carpetaPath = $carpetaId;
                Storage::disk('public')->makeDirectory($carpetaPath);
    
                Guardar el archivo en la carpeta
                $file->storeAs('public/' . $carpetaPath, $fileName);//Guarda de forma publica*/

                $file->storeAs($carpetaId, $fileName); // Guarda de forma privada

    
                // Guardar los datos en la base de datos
                $archivo = new Archivo();
                $archivo->carpeta_id = $carpetaId;
                $archivo->nombre = $fileName;
                $archivo->estado_archivo = 'privado';
                $archivo->nombre_archivo = $request->nombre_archivo;
                $archivo->folio = $request->folios;
                $archivo->personal_dirigido = $request->personal_dirigido;
                $archivo->ubicacion = $request->ubicacion;
                $archivo->descripcion = $request->descripcion;
    
                $archivo->save();
            }
        }
    
        toastr()->success('Se subio el archivo correctamente', 'Notificación');
        return redirect()->back();
    }
  


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getArchivos($id)
    {
        $archivos = Archivo::select('id', 'nombre', 'nombre_archivo', 'estado_archivo')->where('carpeta_id', $id)->get();
    
        // Agrega la URL del archivo a cada archivo en la colección
        $archivos->transform(function ($archivo) use ($id) {
            $rutaArchivo = 'storage/' . $id . '/' . $archivo->nombre;
            $archivo->url = asset($rutaArchivo); // Genera la URL correcta para el almacenamiento privado
            return $archivo;
        });
    
        return DataTables::collection($archivos)->toJson();
    }
}
