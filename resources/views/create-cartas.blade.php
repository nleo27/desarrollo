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

        <div class="card-body form-container" style="background-color: #F8F7F7">
            <form action="{{ route('cartas.store') }}" method="POST">
                @csrf
                <div class="form-group text-center">
                    <label for="nombreAnio" class="mx-auto">Nombre del Año:</label>
                    <input style="border: 2px solid" type="text" id="nombreAnio" name="nombreAnio" class="form-control w-50 mx-auto" required>
                </div>
                <div class="form-group row justify-content-between">
                    <div class="col-md-6">
                        <label for="nombreCarta">Nombre de la Carta:</label>
                        <input style="border: 2px solid" type="text" id="nombreCarta" name="nombreCarta" class="form-control" required>
                    </div>
                    
                    <div class="col-md-3 ">
                        <label for="fechaCarta">Fecha de la Carta:</label>
                        <input style="border: 2px solid" type="date" id="fechaCarta" name="fechaCarta" class="form-control" required>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="dirigido">Dirigido a:</label>
                        
                        <select style="border: 2px solid" id="dirigido" name="dirigido" class="form-select" required>
                            @foreach ($adminUsers as $adminUser) 
                            <option value="{{ $adminUser->id }}">{{ $adminUser->name }}</option>
                            @endforeach
                            
                            <!-- Puedes añadir más opciones según sea necesario -->
                        </select>
                        
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="cargo">Cargo:</label>
                        <input style="border: 2px solid" type="text" id="cargo" name="cargo" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <label for="nombreInstitucion">Nombre de la Institución:</label>
                        <input style="border: 2px solid" type="text" id="nombreInstitucion" name="nombreInstitucion" class="form-control">
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-md-6">
                        <label for="asunto">Asunto:</label>
                        <input style="border: 2px solid" type="text" id="asunto" name="asunto" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-md-6">
                        <label for="ref">Ref:</label>
                        <input style="border: 2px solid" type="text" id="ref" name="ref" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-9">
                        
                        <input style="border: 2px solid" type="text" id="id_usuario" name="id_usuario" value="{{Auth::user()->id}}" class="form-control" hidden>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cuerpoMensaje">Cuerpo del Mensaje:</label>
                    <textarea style="border: 2px solid" id="cuerpoMensaje" name="cuerpoMensaje" class="form-control" required></textarea>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="fechaCaduca">Fecha que Caduca:</label>
                        <input style="border: 2px solid" type="date" id="fechaCaduca" name="fechaCaduca" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Continuar" class="btn btn-primary">
                </div>
            </form>
        </div>

       
    </div>

   

   
@endsection