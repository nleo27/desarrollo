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
        <div class="card-body">
            
            <p><strong>Nombre de la Carta:</strong> {{ $carta->nombre_carta }}</p>
            <p><strong>Fecha de la Carta:</strong> {{ $carta->fecha_carta }}</p>
            <p><strong>Dirigido a:</strong> {{ $carta->dirigido }}</p>
            <p><strong>Cargo:</strong> {{ $carta->cargo }}</p>
            <p><strong>Institución:</strong> {{ $carta->institucion }}</p>
            <p><strong>Asunto:</strong> {{ $carta->asunto }}</p>
            <p><strong>Referencia:</strong> {{ $carta->referencia }}</p>
            <p><strong>ID del Usuario:</strong> {{ $carta->id_usuario }}</p>
            <p><strong>Mensaje:</strong> {{ $carta->mensaje }}</p>
            <p><strong>Fecha de Caducidad:</strong> {{ $carta->fecha_caduca }}</p>

            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#crear-requerimiento{{ $carta->id}}"><i class="fas fa-edit"></i>Agregar Requerimiento</button>
        </div>
        <hr>

        <h2>Requerimientos de la Carta</h2>
        @if ($requerimientos->isEmpty())
            <p>No hay requerimientos para esta carta.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requerimiento</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Caducidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requerimientos as $requerimiento)
                    <tr>
                        <td>{{ $requerimiento->id }}</td>
                        <td>{{ $requerimiento->texto_requerimiento }}</td>
                        <td>{{ $requerimiento->fecha_inicio }}</td>
                        <td>{{ $requerimiento->fecha_fin }}</td>
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


@endsection

    
