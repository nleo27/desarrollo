@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Usuarios')

@section('content')
    <div class="card mt-5">
        <div class="card-header ">
            <h3 class="card-title">Lista de Usuarios</h3>
            @can('create_usuario.create')

            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-usuario"><i class="fas fa-users"></i> Registrar Usuario</button>
            </div>
                
            @endcan
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-usuario">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Área</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario) 
                        
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->dni }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->telefono }}</td>
                                <td>{{ $usuario->area ? $usuario->area->nombre : 'N/A' }}</td>
                                <td>{{ $usuario->rol() }}</td>
                                <td>
                                    @can('create_usuario.editar')
                                    <a class="btn btn-success btn-sm" href="{{ route('usuarios.edit', ['id' => $usuario->id]) }}"><i class="fas fa-edit"></i> Editar</a>
                                    @endcan
                                    
                                    @can('create_usuario.eliminar')
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminar-usuario"><i class="fas fa-trash-alt"></i> Eliminar</button>    
                                    @endcan
                                    
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Usuario -->
        <div class="modal fade" id="modal-registrar-usuario">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title"><i class="fas fa-users"></i> Registrar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('usuarios.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="dni" name="dni">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="name" name="name">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos:</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="apellidos" name="apellidos">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-user-edit"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono">Teléfono:</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="telefono" name="telefono">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="area">Área:</label>
                                        <select class="form-select" aria-label="Default select example"  id="area_id" name="area_id">
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                        @endforeach    
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="correo">Correo:</label>
                                        <div class="input-group mb-3">
                                            <input type="email" class="form-control" id="email" name="email">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="clave">Clave:</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="password" name="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
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

