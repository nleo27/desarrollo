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

            <a href="">
                <button type="button">Agregar Requerimiento</button>
            </a>
        </div>

        
    </div>

@endsection

    
