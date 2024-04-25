
@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Documento')

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title">Crear nuevo Archivador</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-archivador">Registrar Archivador</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-archivadores">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    
                        <tr>
                            <td>01</td>
                            <td>Carpera 01</td>
                            <td>Cualquier información</td>
                            
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-editar-area"><i class="fas fa-edit"></i> Editar</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminar-area"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                    
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Archivador -->
    <div class="modal fade" id="modal-registrar-archivador">
        <div class="modal-dialog modal-lg"> <!-- Cambié modal-dialog a modal-lg para hacerlo más ancho -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Archivador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre de Archivador</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                        <div class="form-group">
                            <label for="estante">Estante</label>
                            <input type="text" class="form-control" id="estante" name="estante" required>
                        </div>
                        <div class="form-group">
                            <label for="modulo">Módulo</label>
                            <input type="text" class="form-control" id="modulo" name="modulo" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer"> <!-- Añadí el modal-footer para los botones -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear Carpeta</button>
                        </div>
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
    new DataTable('#lista-archivadores',{
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
        $('#modal-registrar-archivador').on('shown.bs.modal', function () {
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

        $('#modal-registrar-archivador').on('hidden.bs.modal', function () {
            $('#nombre-error').text('');
        });
    });
</script>
@endsection


