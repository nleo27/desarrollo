@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Grupos')

@section('content')
    <div class="card mt-5">
        <div class="card-header ">
            <h3 class="card-title">Crear Grupos</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-grupo"><i class="fas fa-users"></i> Crear Grupo</button>
            </div>
                        
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-grupo">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo) 
                        
                            <tr>
                                <td>{{ $grupo->id }}</td>
                                <td>{{ $grupo->nombre }}</td>
                                <td>{{ $grupo->descripcion}}</td>
                                <td>{{ $grupo->created_at}}</td>
                                
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Opciones
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#"><i class="fas fa-edit text-warning"></i> Editar</a>
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-eliminar-usuario"><i class="fas fa-trash-alt text-danger"></i> Eliminar</button>
                                            <button type="button" class="dropdown-item " data-toggle="modal" data-target="#modal-agregar-area{{ $grupo->id }}"><i class="fas fa-plus-circle text-info"></i> Agregar Areas</button>
                                        </div>
                                    </div>
                                </td>
                                    <!-- Modal Agregar Area al Grupo -->
                                    <div class="modal fade" id="modal-agregar-area{{ $grupo->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h4 class="modal-title"><i class="fas fa-users"></i> Agregar Area al grupo</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('guardar_areas') }}" method="POST" id="form-agregar-areas">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                
                                                                <input type="text" class="form-control" id="id_{{ $grupo->id }}" name="grupo_id" value="{{ $grupo->id }}" hidden>
                                                                <div class="form-group">
                                                                    <label for="area">Agregar Área:</label>
                                                                    <select class="form-select" aria-label="Default select example" id="area_id_{{ $grupo->id }}" name="area_id">
                                                                        @foreach($areas as $area)
                                                                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <!-- Lista de áreas seleccionadas -->
                                                                <div class="form-group">
                                                                    <label for="areas_seleccionadas">Áreas Seleccionadas:</label>
                                                                    <ul class="list-group" id="areas_seleccionadas_{{ $grupo->id }}">
                                                                        <!-- Aquí se agregarán las áreas seleccionadas -->
                                                                    </ul>
                                                                    <input type="hidden" name="areas[]" value="{{ $area->id }}">
                                                                </div>

                                                                <!-- Botón para agregar área -->
                                                                <button type="button" class="btn btn-success btn-agregar-area" id="agregar_area_{{ $grupo->id }}" data-modal-id="{{ $grupo->id }}"><i class="fas fa-plus"></i> Agregar Área</button>

                                                                <!-- Botón para guardar áreas -->
                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Registrar Grupo -->
        <div class="modal fade" id="modal-registrar-grupo">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h4 class="modal-title"><i class="fas fa-users"></i> Crear grupo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('grupos.creacion') }}" method="POST" >
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="descripcion" name="descripcion">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                            </div>
                                        </div>
                                   </div>
                       
                                </div>
                                
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Grupo</button>
                        </form>
                    </div>
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
        new DataTable('#lista-grupo',{
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
    $(document).ready(function () {
        $('.btn-agregar-area').click(function () {
            var modalId = $(this).data('modal-id');
            var areasSeleccionadas = $('#areas_seleccionadas_' + modalId);

            console.log('Botón "Agregar Área" clickeado');

            // Eliminar área seleccionada
            $('#modal-agregar-area' + modalId).on('click', '.btn-danger', function () {
                console.log('Evento click del botón "Eliminar Área" manejado');
                $(this).closest('li').remove();
            });
        });

        // Manejar el evento click del botón "Agregar Área"
            // Manejar el evento click del botón "Agregar Área"
            $(document).on('click', '[id^=agregar_area_]', function () {
                var modalId = $(this).data('modal-id');
                var areaIds = $('#areas_seleccionadas_' + modalId + ' input[type=hidden]').map(function() {
                    return $(this).val();
                }).get();

                var areaId = $('#area_id_' + modalId).val();
                var areaNombre = $('#area_id_' + modalId + ' option:selected').text();
                var areasSeleccionadas = $('#areas_seleccionadas_' + modalId);

                console.log('Evento click del botón "Agregar Área" manejado');

                if (areaId === "") {
                    alert('Por favor, seleccione un área.');
                } else if (areaIds.includes(areaId)) {
                    alert('¡Esta área ya fue agregada!');
                } else {
                    areasSeleccionadas.append('<li class="list-group-item">' + areaNombre + '<button type="button" class="btn btn-danger btn-sm float-end"><i class="fas fa-times"></i></button><input type="hidden" name="areas[]" value="' + areaId + '"></li>');
                }
            });

        // Manejar el envío del formulario para guardar áreas
        $('form').submit(function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function (response) {
                    alert('Áreas guardadas exitosamente');
                    // Puedes agregar aquí alguna lógica adicional después de guardar las áreas
                },
                error: function (xhr, status, error) {
                    alert('Error al guardar las áreas');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection

