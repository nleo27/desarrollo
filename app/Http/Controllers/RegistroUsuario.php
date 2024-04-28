<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class RegistroUsuario extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required',
            'name' => 'required',
            'apellidos' => 'required',
            'area_id' => 'required',
            'email' => 'required',
            'rol' => 'nullable',
            'password' => 'required',
        ]);

        $usuario = new Usuario();
        $usuario->dni = $request->dni;
        $usuario->name = $request->name;
        $usuario->apellidos = $request->apellidos;
        $usuario->telefono = $request->telefono;
        $usuario->area_id = $request->area_id;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->password = Hash::make($request->password);
        $usuario->created_at = now();
        $usuario->updated_at = now();
        $usuario->save();

        toastr()->success('Registro ingresado', 'Notificación');

        return redirect()->route('create_usuario');
    }
}
