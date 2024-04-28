<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;
use App\Models\Usuario;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CreateUsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('area')->get();
        $areas = Area::all();
        return view('create-usuario', compact('usuarios', 'areas'));
    }

    public function edit($id)
    {
        $roles= Role::all();
        $usuario = Usuario::findOrFail($id);
        $areas = Area::all();
        return view('edit', compact('usuario', 'roles', 'areas'));
    }

    public function update(Request $request, $id)
{
    // Verificar si el DNI ya está en uso por otro usuario
    $existingUserWithDNI = Usuario::where('dni', $request->input('dni-edit'))->where('id', '<>', $id)->exists();
    if ($existingUserWithDNI) {
        toastr()->error('El DNI ya está en uso por otro usuario.', 'Error');
        return redirect()->back()->withInput();
    }

     
    // Verificar si el correo electrónico ya está en uso por otro usuario
    $existingUserWithEmail = Usuario::where('email', $request->input('email-edit'))->where('id', '<>', $id)->exists();
    if ($existingUserWithEmail) {
        toastr()->error('El correo electrónico ya está en uso por otro usuario.', 'Error');
        return redirect()->back()->withInput();
    }

    // Validar los datos del formulario
    $request->validate([
        'dni-edit' => [
            'required',
            Rule::unique('users', 'dni')->ignore($id),
        ],
        'email-edit' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($id),
        ],
    ]);

           
    $usuario = Usuario::findOrFail($id); // Obtener el usuario por su ID

    // Obtener el nombre del rol seleccionado
    $roleName = $request->input('role');

    // Sincronizar los roles del usuario
    $usuario->syncRoles([$roleName]);

    // Actualizar los datos del usuario
    $usuario->dni = $request->input('dni-edit');
    $usuario->name = $request->input('nombre-edit');
    $usuario->apellidos = $request->input('apellidos-edit');
    $usuario->telefono = $request->input('telefono-edit');
    $usuario->email = $request->input('email-edit');
    $usuario->area_id = $request->input('area_id');

    // Actualizar la contraseña solo si se envía en el formulario
    if ($request->filled('password-edit')) {
        $usuario->password = Hash::make($request->input('password-edit')); // Usar Hash en lugar de bcrypt
    }

    $usuario->save();

    toastr()->success('Se actualizó correctamente', 'Notificación');

    return redirect()->route('create_usuario');
}
}
