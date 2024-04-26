<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;
use App\Models\Usuario;

class CreateUsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('area')->get();
        $areas = Area::all();
        return view('create-usuario', compact('usuarios', 'areas'));
    }
}
