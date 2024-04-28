@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap4.css">
@endsection

@section('title', 'Area')

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title">Crear nueva area</h3>
            @can('create_area.create')
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-area">Registrar Area</button>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-area">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($areas as $area)
                        <tr>
                            <td>{{ $area->id }}</td>
                            <td>{{ $area->nombre }}</td>
                            <td>{{ $area->descripcion }}</td>
                            
                            <td>
                                @can('create_area.editar')
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-area{{$area->id}}"><i class="fas fa-edit"></i> Editar</button>                                                                    
                                @endcan
                                
                                @can('create_area.eliminar')
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{$area->id}}"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                @endcan
                            </td>

                            <!-- Modal Editar Area -->
                            <div class="modal fade" id="edit-area{{$area->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Editar Área</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form-editar-area" action="{{ route('areas.update', ['id' => $area->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="edit-nombre">Nombre</label>
                                                    <input type="text" class="form-control" value= "{{ $area->nombre }}" id="edit-nombre" name="nombre" require>
                                                    <input type="hidden" name="id" value="{{ $area->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-descripcion">Descripción</label>
                                                    <input type="text" class="form-control" value= "{{ $area->descripcion }}" id="edit-descripcion" name="descripcion" require>
                                                </div>
                                                <button type="submit" id="btn-editar" class="btn btn-primary">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Confirmar Eliminación -->
                            <div class="modal fade" id="confirm-delete{{$area->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Confirmar Eliminación</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar el área "{{ $area->nombre }}"?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('areas.destroy', $area->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Area-->
    <div class="modal fade" id="modal-registrar-area">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Area</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-registrar-area" action="{{ route('areas.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                            <span id="nombre-error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion">
                        </div>
                        <button type="button" id="btn-registrar" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap4.js"></script>

<script>
    new DataTable('#lista-area',{
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


<script>
   
    $(document).ready(function() {
        $('#modal-registrar-area').on('shown.bs.modal', function () {
            $('#nombre-error').text('');
            $('#nombre').val('');
            $('#descripcion').val('');
        });

        $('#btn-registrar').click(function() {
            var nombre = $('#nombre').val();
            if (nombre === '') {
                $('#nombre-error').text('El campo nombre es obligatorio.');
                return false;
            }

            // Si todos los campos están llenos, envía el formulario
            $('#form-registrar-area').submit();
        });

        $('#modal-registrar-area').on('hidden.bs.modal', function () {
            $('#nombre-error').text('');
        });
    });

    

 </script>

 
@endsection


