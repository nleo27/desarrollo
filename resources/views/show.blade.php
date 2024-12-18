@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap4.css">
@endsection

@section('title', 'Cartas')

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title"><strong>Resumen de la Carta</strong></h3>
        </div>
<div class="card-body" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px;">

    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Nombre de la Carta:</strong> {{ $carta->nombre_carta }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Fecha de la Carta:</strong> {{ $carta->fecha_carta }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Dirigido a:</strong> {{ $carta->dirigido }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Cargo:</strong> {{ $carta->cargo }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Institución:</strong> {{ $carta->institucion }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Asunto:</strong> {{ $carta->asunto }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Referencia:</strong> {{ $carta->referencia }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>ID del Usuario:</strong> {{ $carta->id_usuario }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Mensaje:</strong> {{ $carta->mensaje }}</p>
    <p style="background-color: #e9f7fd; padding: 10px; border-radius: 5px;"><strong>Fecha de Caducidad:</strong> {{ $carta->fecha_caduca }}</p>

    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#crear-requerimiento{{ $carta->id}}"><i class="fas fa-edit"></i> Agregar Requerimiento</button><br><br>

    @php
        use Carbon\Carbon;

        // Obtener las fechas de la carta
        $fechaInicio = Carbon::parse($carta->fecha_carta);
        $fechaFin = Carbon::parse($carta->fecha_caduca);

        // Calcular los días restantes entre la fecha de la carta y la fecha de caducidad
        $diasRestantes = $fechaInicio->diffInDays($fechaFin, false); // false para obtener días negativos si la fecha de caducidad ya pasó

        $mensaje = '';
        $colorTexto = 'black';

        // Definir el mensaje y el color dependiendo de los días restantes
        if ($diasRestantes > 3) {
            $mensaje = "Quedan $diasRestantes días para el envío de la carta.";
            $colorTexto = 'blue'; // Color azul si quedan 4 días o más
        } elseif ($diasRestantes <= 3 && $diasRestantes > 0) {
            $mensaje = "Quedan $diasRestantes días para el envío de la carta.";
            $colorTexto = 'red'; // Color rojo si quedan 3 o menos días
        } elseif ($diasRestantes == 0) {
            $mensaje = "Hoy es el último día para el envío de la carta.";
            $colorTexto = 'orange'; // Naranja si es el último día
        } else {
            $mensaje = "El plazo para enviar la carta ha vencido.";
            $colorTexto = 'red'; // Rojo si ya venció el plazo
        }
    @endphp

    <p style="background-color: #fff3cd; padding: 10px; border-radius: 5px; color: {{ $colorTexto }}">
        <strong>Días restantes:</strong> 
        {{ $mensaje }}
    </p>
</div>

        <hr>

        <h2 style="text-align: center; background-color: #007bff; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            Requerimientos de la Carta
        </h2>
        @if ($requerimientos->isEmpty())
        <p style="text-align: center; color: red; font-weight: bold; font-size: 18px;">No hay requerimientos para esta carta.</p>
        @else
        <table class="table table-bordered table-striped" style="width: 100%; border-radius: 8px; overflow: hidden;">
            <thead style="background-color: #007bff; color: white; text-align: center;">
                <tr>
                    <th>ID</th>
                    <th>Requerimiento</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Caducidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requerimientos as $requerimiento)
                <tr style="text-align: center; background-color: #f8f9fa;">
                    <td>{{ $requerimiento->id }}</td>
                    <td>{{ $requerimiento->texto_requerimiento }}</td>
                    <td>{{ $requerimiento->fecha_inicio }}</td>
                    <td>{{ $requerimiento->fecha_fin }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" style="margin-right: 5px;" data-toggle="modal" data-target="#editar-requerimiento{{ $requerimiento->id }}"><i class="fas fa-edit"></i> Editar</button>
                        <!-- Botón para eliminar -->
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminar-requerimiento{{ $requerimiento->id }}"><i class="fas fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        
    </div>

    <!-- Modal Agregar Requerimiento-->
    
        <div class="modal fade" id="crear-requerimiento{{ $carta->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Añadir Requerimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('requerimientos.store', ['carta' => $carta->id]) }}">
                        @csrf  <!-- Incluir token CSRF -->
                        <div class="modal-body">
                            <input type="hidden" value="{{ $carta->id}}" id="id_carta" name="id_carta">
                            <div class="form-group">
                                <label for="requerimiento">Requerimiento</label>
                                <textarea class="form-control" id="requerimiento" name="requerimiento"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fecha-inicio">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $carta->fecha_carta }}" readonly >
                            </div>
                            <div class="form-group">
                                <label for="fecha-caduca">Caduca</label>
                                <input type="date" class="form-control" id="fecha_caduca" name="fecha_caduca" value="{{ $carta->fecha_caduca }}" readonly >
                            </div>
                            <div class="form-group">
                                <label for="dirigido">Dirigido</label>
                                <select class="form-control" id="dirigido" name="dirigido">
                                    @foreach ($adminUsers as $adminUser) 
                                        <option value="{{ $adminUser->id }}">{{ $adminUser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal para editar requerimiento -->
            @foreach ($requerimientos as $requerimiento)
            <div class="modal fade" id="editar-requerimiento{{ $requerimiento->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Requerimiento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('requerimientos.update', $requerimiento->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="id_carta" value="{{ $carta->id }}">
                                <div class="form-group">
                                    <label for="requerimiento">Requerimiento</label>
                                    <textarea class="form-control" id="requerimiento" name="requerimiento">{{ $requerimiento->texto_requerimiento }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="fecha-inicio">Fecha de Inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $requerimiento->fecha_inicio }}" readonly> 
                                </div>
                                <div class="form-group">
                                    <label for="fecha-caduca">Caduca</label>
                                    <input type="date" class="form-control" id="fecha_caduca" name="fecha_caduca" value="{{ $requerimiento->fecha_fin }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="dirigido">Dirigido</label>
                                    <select class="form-control" id="dirigido" name="dirigido">
                                        @foreach ($adminUsers as $adminUser)
                                            <option value="{{ $adminUser->id }}" {{ $adminUser->id == $requerimiento->dirigido_id ? 'selected' : '' }}>{{ $adminUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
    <!-- Modal de confirmación para eliminar requerimiento -->
            @foreach ($requerimientos as $requerimiento)
            <div class="modal fade" id="eliminar-requerimiento{{ $requerimiento->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar este requerimiento?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                            <!-- Formulario para eliminar requerimiento -->
                            <form method="POST" action="{{ route('requerimientos.destroy', $requerimiento->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


@endsection

    
