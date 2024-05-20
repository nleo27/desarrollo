<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivoGrupo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ArchivoGrupoController extends Controller
{
    
    public function getArchivos(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Verificar si el usuario está autenticado
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Obtener el área asociada al usuario
        $area = $usuario->area;

        // Verificar si el usuario tiene un área asociada
        if (!$area) {
            return response()->json(['error' => 'Área no encontrada para este usuario'], 404);
        }

        // Obtener el grupo_id asociado al área del usuario
        $grupo = $area->grupos()->first();

        if (!$grupo) {
            return response()->json(['error' => 'Área no pertenece a ningún grupo'], 404);
        }

        $grupoId = $grupo->pivot->grupo_id;

        // Obtener solo los archivos que pertenecen al grupo del usuario
        $archivos = ArchivoGrupo::where('grupo_area_id', $grupoId)->get();

        // Añadir la ruta completa del archivo
        $archivos = $archivos->map(function($archivo) {
            $archivo->url = Storage::url('grupo_' . $archivo->grupo_area_id . '/' . $archivo->ruta_archivo);
            return $archivo;
        });

        return DataTables::collection($archivos)->toJson();
    }

   
    public function create()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
               
        // Verificar si el usuario está autenticado
        if (!$usuario) {
            // Manejar el caso en que el usuario no esté autenticado
            abort(401, 'Usuario no autenticado');
        }

        // Obtener el área asociada al usuario
        $area = $usuario->area;
        // Inicializar la variable $mensaje
        $mensaje = '';

        // Verificar si el usuario tiene un área asociada
        if (!$area) {
            // Manejar el caso en que el usuario no tenga un área asociada
            abort(404, 'Área no encontrada para este usuario');
        }

        // Obtener el grupo_id asociado al área del usuario
        $grupoId = null;
        $grupo = $area->grupos()->first();
        if ($grupo) {
            $grupoId = $grupo->id;
        } else {
            $mensaje = 'El área asignada a este usuario aún no pertenece a ningún grupo.';
        }

        // Pasar el área y el grupo_id (o el mensaje) a la vista
        return view('create-grupo-areas', compact('grupoId', 'mensaje'));
    }

    public function store(Request $request)
    {
        // Constante para el tamaño máximo de archivo (en bytes)
        define('MAX_FILE_SIZE', 3145728); // 3MB
    
        // Array de extensiones válidas
        $validExtensions = ['pdf', 'xlsx', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'avif'];
    
        $request->validate([
            'upload.*' => 'required|max:' . MAX_FILE_SIZE, // Validar tamaño de archivo
            'nombre_archivo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'grupo_id' => 'required|integer|exists:grupos,id',
        ]);
    
        $grupoId = $request->input('grupo_id');
        $grupoFolder = 'Grupo_' . $grupoId;
    
        $hasFileError = false; // Bandera para indicar si hay un error de archivo
        
    
        // Verificar si se ha subido algún archivo
        if ($request->hasFile('upload')) {
            foreach ($request->file('upload') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();
    
                // Validar tamaño del archivo
                if ($file->getSize() > MAX_FILE_SIZE) {
                    toastr()->error('El archivo ' . $file->getClientOriginalName() . ' excede el tamaño máximo permitido de 3MB.', 'Error de tamaño de archivo');
                    $hasFileError = true;
                    continue; // Saltar al siguiente archivo
                }
    
                // Validar extensión de archivo
                if (!in_array($fileExtension, $validExtensions)) {
                    toastr()->error('El archivo ' . $fileName . ' no es válido. Solo se permiten archivos PDF, XLSX, DOC, DOCX, JPG, PNG, JPEG y AVIF.', 'Error de archivo');
                    $hasFileError = true;
                    continue; // Saltar al siguiente archivo
                }
    
                // Crear carpeta si no existe
                if (!Storage::exists($grupoFolder)) {
                    Storage::makeDirectory($grupoFolder);
                }
    
                // Almacenar archivo
                $filePath = $file->storeAs($grupoFolder, $fileName);
                $filesUploaded = true;
    
                // Guardar información en la base de datos
                ArchivoGrupo::create([
                    'nombre' => $request->input('nombre_archivo'),
                    'ruta_archivo' => $fileName,
                    'grupo_area_id' => $grupoId,
                    'descripcion' => $request->input('descripcion'),
                ]);
            }
        }
    
        if ($hasFileError) {
            return redirect()->route('archivo-grupo.create');
        }else {
            return redirect()->route('archivo-grupo.create')->with('success', 'Archivos subidos y guardados correctamente.');
        }
    }

    public function eliminar(Request $request, $id)
    {
        // Buscar el archivo por su ID
        $archivo = ArchivoGrupo::findOrFail($id);

        // Eliminar el archivo del sistema de archivos
        Storage::delete('grupo_' . $archivo->grupo_area_id . '/' . $archivo->ruta_archivo);

        // Eliminar el registro de la base de datos
        $archivo->delete();

    }

    public function updateAjax(Request $request, $id)
    {
        // Encuentra el archivo por su ID
        $archivo = ArchivoGrupo::findOrFail($id);

        // Validar la solicitud
        $request->validate([
            'edit_archivo' => 'required|string|max:255',
            'edit_descripcion' => 'nullable|string|max:255',
            'upload' => 'nullable|array|max:5', // Máximo 5 archivos permitidos
            'upload.*' => 'nullable|file|mimes:doc,docx,pdf,jpeg,png,jpg|max:2048', // Tipos y tamaño de archivo permitidos
        ]);

        // Actualizar los campos del archivo
        $archivo->nombre = $request->input('edit_archivo');
        $archivo->descripcion = $request->input('edit_descripcion');

        // Reemplazar los archivos si se han subido nuevos
        if ($request->hasFile('upload')) {
            foreach ($request->file('upload') as $file) {
                // Guardar el archivo en el almacenamiento
                $archivo->ruta_archivo = $file->store('grupo_' . $archivo->grupo_area_id);
            }
        }

        // Guardar los cambios en la base de datos
        $archivo->save();

        // Retorna una respuesta JSON exitosa
        return response()->json(['message' => 'Archivo actualizado correctamente'], 200);
    }





}
