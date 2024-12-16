<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta;
use App\Models\Usuario;
use App\Models\Requerimiento;

class CartaController extends Controller
{
    public function index()
    {
        $adminUsers = Usuario::role('Administrador')->get();
        return view('create-cartas',compact('adminUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombreAnio' => 'required|string|max:255',
            'nombreCarta' => 'required|string|max:255',
            'fechaCarta' => 'required|date',
            'dirigido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'nombreInstitucion' => 'required|string|max:255',
            'asunto' => 'required|string|max:255',
            'ref' => 'nullable|string|max:255',
            'id_usuario' => 'required|exists:users,id',
            'cuerpoMensaje' => 'required',
            'fechaCaduca' => 'required|date',
        ]);

        
        $carta= new Carta();
        $carta->nombre_anio = $request->nombreAnio;
        $carta->nombre_carta = $request->nombreCarta;
        $carta->fecha_carta= $request->fechaCarta;
        $carta->dirigido= $request->dirigido;
        $carta->cargo= $request->cargo;
        $carta->institucion= $request->nombreInstitucion;
        $carta->asunto = $request->asunto;
        $carta->referencia= $request->ref;
        $carta->id_usuario= $request->id_usuario;
        $carta->mensaje= $request->cuerpoMensaje;
        $carta->fecha_caduca = $request->fechaCaduca;
        $carta->save();

        toastr()->success('Se creo la carpeta corectamente', 'Notificación');

        return redirect()->route('cartas.show');
    }

    public function show(Carta $carta)
    {
        $adminUsers = Usuario::role('Administrador')->get();
        $requerimientos = $carta->requerimientos;
        return view('show', compact('carta', 'adminUsers', 'requerimientos'));
    }

    public function storeRequerimiento(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_carta' => 'required|integer|exists:cartas,id',
            'requerimiento' => 'required|string',
            'dirigido' => 'required|integer|exists:users,id',
        ]);

        // Crear un nuevo requerimiento

        $requerimiento= new Requerimiento();
        $requerimiento->id_carta = $request->id_carta;
        $requerimiento->texto_requerimiento = $request->requerimiento;
        $requerimiento->fecha_inicio = $request->fecha_inicio;
        $requerimiento->fecha_fin = $request->fecha_caduca;
        $requerimiento->dirigido = $request->dirigido;
        $requerimiento->save();
       

        // Mostrar un mensaje de éxito con Toastr
        toastr()->success('Requerimiento asignado correctamente', 'Notificación');
        

        // Redirigir a la vista 'show' de la carta con el mensaje de éxito
        return redirect()->back();
        //return redirect()->route('show', $request->input('id_carta'));
    }

    
}
