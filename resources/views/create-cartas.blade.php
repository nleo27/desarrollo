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
            <h3 class="card-title">Crear Nueva Carta</h3>
        </div>

        <div class="card-body form-container">
            <form action="/submit" method="POST">
                @csrf
                <div class="form-group text-center">
                    <label for="nombreAnio" class="mx-auto">Nombre del Año:</label>
                    <input type="text" id="nombreAnio" name="nombreAnio" class="form-control w-50 mx-auto">
                </div>
                <div class="form-group row justify-content-between">
                    <div class="col-md-3">
                        <label for="numeroCarta">N° de Carta:</label>
                        <input type="text" id="numeroCarta" name="numeroCarta" class="form-control">
                    </div>
                    
                    <div class="col-md-3 ">
                        <label for="fechaCarta">Fecha de la Carta:</label>
                        <input type="date" id="fechaCarta" name="fechaCarta" class="form-control">
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="dirigido">Dirigido a:</label>
                        <input type="text" id="dirigido" name="dirigido" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="cargo">Cargo:</label>
                        <input type="text" id="cargo" name="cargo" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <label for="nombreInstitucion">Nombre de la Institución:</label>
                        <input type="text" id="nombreInstitucion" name="nombreInstitucion" class="form-control">
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-md-6">
                        <label for="asunto">Asunto:</label>
                        <input type="text" id="asunto" name="asunto" class="form-control">
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-md-6">
                        <label for="ref">Ref:</label>
                        <input type="text" id="ref" name="ref" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cuerpoMensaje">Cuerpo del Mensaje:</label>
                    <textarea id="cuerpoMensaje" name="cuerpoMensaje" class="form-control"></textarea>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="fechaCaduca">Fecha que Caduca:</label>
                        <input type="date" id="fechaCaduca" name="fechaCaduca" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Continuar" class="btn btn-primary">
                </div>
            </form>
        </div>

       
    </div>

   

   
@endsection