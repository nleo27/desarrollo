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
        $request->validate([
            'upload.*' => 'required|mimes:pdf,xlsx,doc,docx,jpg,png,jpeg,avif|max:3072', // 3MB
            'nombre_archivo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'grupo_id' => 'required|integer|exists:grupos,id',
        ]);

        $grupoId = $request->input('grupo_id');
        $grupoFolder = 'Grupo_' . $grupoId;

        // Crear carpeta si no existe
        if (!Storage::exists($grupoFolder)) {
            Storage::makeDirectory($grupoFolder);
        }

        if ($request->hasFile('upload')) {
            foreach ($request->file('upload') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs($grupoFolder, $fileName);

                // Guardar la información en la base de datos
                ArchivoGrupo::create([
                    'nombre' => $request->input('nombre_archivo'),
                    'ruta_archivo' => $fileName,
                    'grupo_area_id' => $grupoId,
                    'descripcion' => $request->input('descripcion'),
                ]);
            }
        }

        return redirect()->route('archivo-grupo.create')->with('success', 'Archivos subidos y guardados correctamente.');
    }
}
