<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta;
use App\Models\Usuario;
use App\Models\Requerimiento;
use App\Events\PostCreated;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NuevaCartaNotification; // Importa la notificación
use Illuminate\Support\Facades\Auth;

class CartaController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios excepto el usuario autenticado
        $usuarios = Usuario::where('id', '!=', auth()->id())->get();
        return view('create-cartas', compact('usuarios'));
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

        
       event(new PostCreated($carta));

        toastr()->success('Se creo la carta corectamente', 'Notificación');

        return redirect()->route('cartas.show', ['carta' => $carta->id]);
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



    public function listarCartas()
    {
        
            // Obtiene solo las cartas creadas por el usuario autenticado
        $cartas = Carta::where('id_usuario', auth()->user()->id)->get();

        // Verifica si el usuario tiene cartas
        $noCartasMessage = $cartas->isEmpty() ? 'Aún no has creado cartas.' : null;

        // Retorna la vista con las cartas y el mensaje si no tiene cartas
        return view('create-lista-cartas', compact('cartas', 'noCartasMessage'));
    }

    public function obtenerRequerimientos($id)
        {
            // Encuentra la carta por ID
            $carta = Carta::find($id);

            if ($carta) {
                // Obtén los requerimientos de la carta
                $requerimientos = $carta->requerimientos;  // Relación definida en el modelo Carta

                // Retorna los requerimientos como una respuesta JSON
                return response()->json(['requerimientos' => $requerimientos]);
            } else {
                // Si no se encuentra la carta, se retornan sin requerimientos
                return response()->json(['requerimientos' => []]);
            }
        }

        public function update(Request $request, $id)
        {
            // Encuentra el requerimiento que se va a actualizar
            $requerimiento = Requerimiento::findOrFail($id);
        
            // Actualiza los datos del requerimiento
            $requerimiento->update([
                'texto_requerimiento' => $request->input('requerimiento'),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_fin' => $request->input('fecha_caduca'),
                'dirigido_id' => $request->input('dirigido'),
            ]);
        
            // Redirige con un mensaje de éxito
            return redirect()->route('cartas.show', ['carta' => $request->input('id_carta')])
                             ->with('success', 'Requerimiento actualizado correctamente.');
        }

        public function destroy($id)
            {
                // Encuentra el requerimiento por su ID
                $requerimiento = Requerimiento::findOrFail($id);

                // Obtener el ID de la carta relacionada
                $cartaId = $requerimiento->id_carta;

                // Eliminar el requerimiento
                $requerimiento->delete();

                // Redirigir a la página de la carta correspondiente, pasando el ID de la carta
                return redirect()->route('cartas.show', ['carta' => $cartaId])
                                ->with('success', 'Requerimiento eliminado correctamente.');
            }

            public function mostrarCartas()
            {
                            

                // Obtener el ID del usuario autenticado
                    $usuarioId = Auth::id();

                    // Contar el número total de cartas recibidas por el usuario
                    $numeroCartas = Carta::where('dirigido', $usuarioId)->count();

                    // Contar cuántas cartas nuevas llegaron hoy (basado en 'created_at')
                    $cartasNuevas = Carta::where('dirigido', $usuarioId)
                                        ->whereDate('created_at', today()) // Filtra las cartas creadas hoy
                                        ->count();

                    // Retornar el número de cartas y la cantidad de cartas nuevas a la vista
                    return view('home', compact('numeroCartas', 'cartasNuevas'));
            }

            

    
}
