@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Usuarios')

@section('content')
    <h3 class="card-title">Editar Usuarios</h3><br>
    <div class="card mt-3">
        <div class="card-header">
        <form action="{{ route('usuarios.update', ['id' => $usuario->id]) }}" method="POST">

                @csrf <!-- Agregado token csrf -->
                @method('PUT') <!-- Agregado campo _method -->

            <p class="h6">Dni:</p>
            <input type="text" class="form-control" value="{{$usuario->dni}}" id="dni-edit" name="dni-edit">
            <p class="h6">Nombre:</p>
            <input type="text" class="form-control" value="{{$usuario->name}}" id="nombre-edit" name="nombre-edit">
            <p class="h6">Apellidos:</p>
            <input type="text" class="form-control" value="{{$usuario->apellidos}}" id="apellidos-edit" name="apellidos-edit">
            <p class="h6">Telefono:</p>
            <input type="text" class="form-control" value="{{$usuario->telefono}}" id="telefono-edit" name="telefono-edit">
            <p class="h6">Area:</p>
                <select class="form-control" id="area_id" name="area_id">
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ $usuario->area_id == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                    @endforeach  
                </select>
            <p class="h6">Correo:</p>
            <input type="text" class="form-control" value="{{$usuario->email}}" id="email-edit" name="email-edit">
            <p class="h6">Clave:</p>
            <input type="password" class="form-control" id="password-edit" name="password-edit" >

            <p class="h6">Elije el rol:</p>
            
                
            @foreach ($roles as $role)
            <div class="form-check">
                <input type="radio" class="form-check-input" name="role" value="{{$role->name}}" {{$usuario->hasRole($role->name) ? 'checked' : ''}}>
                <label class="form-check-label">{{$role->name}}</label>
            </div>
            @endforeach
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
                </div>
               
        </form>

            
            
            
            
    </div>



@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<script>
    new DataTable('#lista-usuario',{
        responsive: true,
        autoWidth: false,

        "language": {
            "lengthMenu": "Ver _MENU_ registros por página",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Estas en la página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar"
        }
    });
</script>
@endsection

