@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Area')

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title">Crear nueva area</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-area">Registrar Area</button>
            </div>
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
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-editar-area"><i class="fas fa-edit"></i> Editar</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminar-area"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Usuario -->
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

   <!-- Modal Editar Area -->
    <div class="modal fade" id="modal-editar-area">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Área</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-editar-area" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit-nombre">Nombre</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre">
                            <input type="hidden" id="edit-id" name="id">
                        </div>
                        <div class="form-group">
                            <label for="edit-descripcion">Descripción</label>
                            <input type="text" class="form-control" id="edit-descripcion" name="descripcion">
                        </div>
                        <button type="button" id="btn-editar" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

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

 <script>
     $(document).ready(function() {
    $(document).on('click', '.edit-area-btn', function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        var descripcion = $(this).data('descripcion');
        
        console.log(id, nombre, descripcion); // Verifica los datos aquí
        
        $('#edit-id').val(id);
        $('#edit-nombre').val(nombre);
        $('#edit-descripcion').val(descripcion);
        
        $('#modal-editar-area').modal('show'); // Mostrar el modal manualmente
    });
    
    $('#btn-editar').click(function() {
        $('#form-editar-area').submit();
    });
});
 </script>

 
@endsection


