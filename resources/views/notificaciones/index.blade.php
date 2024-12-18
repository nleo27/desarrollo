@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap4.css">
@endsection

@section('title', 'Notificaciones')

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title"><strong>Notificacionesxxxxxxx</strong></h3>
        </div>

        @if($notificaciones->isEmpty())
        <p style="text-align: center; color: red;">No tienes notificaciones nuevas.</p>
    @else
        <ul class="list-group">
            @foreach($notificaciones as $notificacion)
                <li class="list-group-item">
                    @php
                        // Decodificar el campo `data` de la notificación
                        $data = json_decode($notificacion->data, true);
                    @endphp

                    <strong>Carta nueva:</strong> {{ $data['nombre_carta'] ?? 'Sin título' }} <br>
                    <strong>Fecha:</strong> {{ $data['fecha_carta'] ?? 'Sin fecha' }} <br>

                    <!-- Marcar como leída -->
                    <form action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-primary">Marcar como leída</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
        
        
    </div>

   



@endsection