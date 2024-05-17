<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivoGrupo;
use Yajra\DataTables\Facades\DataTables;

class ArchivoGrupoController extends Controller
{
    public function create()
    {
       
        return view('create-grupo-areas');
    }

    public function getArchivos(Request $request)
    {
        $archivos = ArchivoGrupo::all();
 
        return DataTables::collection($archivos)->toJson();
    }
}
