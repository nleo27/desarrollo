@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                                                    <form action="{{ route('guardar_areas') }}" method="POST" id="form-agregar-areas{{ $grupo->id }}">
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
                                                                        @forelse($grupo->area as $area)
                                                                        <li class="list-group-item">
                                                                            {{ $area->nombre }}
                                                                            <a href="#" class="btn btn-warning btn-sm float-end btn-quitar-area" id="eliminar_areas" data-grupo="{{ $grupo->id }}" data-area="{{ $area->id }}"><i class="fas fa-times"></i></a>
                                                                        </li>
                                                                        @empty
                                                                        <li class="list-group-item no-areas" id="mensaje-areas{{ $grupo->id }}" >Aún no hay áreas asignadas al grupo</li>
                                                                        @endforelse
                                                                    </ul>

                                                                </div>
                                                
                                                                <!-- Botón para agregar área -->
                                                                <button type="button" class="btn btn-success btn-agregar-area" id="agregar_area_{{ $grupo->id }}" data-modal-id="{{ $grupo->id }}"><i class="fas fa-plus"></i> Agregar Área</button>
                                                
                                                                <!-- Botón para guardar o actualizar áreas -->
                                                                @if ($grupo->area->isEmpty())
                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                                                                @else
                                                                <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Actualizar</button>
                                                                @endif

                                                             
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
            // Función para ocultar el mensaje de áreas vacías al agregar una nueva área
            $('.btn-agregar-area').click(function () {
                var modalId = $(this).data('modal-id');
                $('#mensaje-areas' + modalId).hide();
            });

            // Observar cambios en los elementos hijos del contenedor de áreas seleccionadas
            $('.list-group').each(function () {
                var modalId = $(this).attr('id').split('_').pop();
                var observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        var listLength = $(mutation.target).children('li:not(.no-areas)').length;
                        if (listLength === 0) {
                            
                            $('#mensaje-areas' + modalId).show();
                        } else {
                            
                            $('#mensaje-areas' + modalId).hide();
                        }
                    });
                });

                // Configuración del observer
                var config = { childList: true };
                observer.observe(this, config);
            });
        });
    </script>


    <script>
            $(document).ready(function () {

            
                $('.btn-agregar-area').click(function () {
                    var modalId = $(this).data('modal-id');
                    var areasSeleccionadas = $('#areas_seleccionadas_' + modalId);
                });

                
                // Manejar el evento click del botón "Agregar Área"
                $(document).on('click', '[id^=agregar_area_]', function () {
                    var modalId = $(this).data('modal-id');
                    var areaId = $('#area_id_' + modalId).val();
                    var areaNombre = $('#area_id_' + modalId + ' option:selected').text();
                    var areasSeleccionadas = $('#areas_seleccionadas_' + modalId);
                    var areasAgregadas = [];

                    // Obtener IDs de las áreas ya agregadas
                    areasSeleccionadas.find('a.btn-quitar-area').each(function() {
                        var areaAgregadaId = $(this).data('area');
                        areasAgregadas.push(areaAgregadaId);
                    });

                    // Si no hay áreas ya agregadas, obtener los IDs de las áreas de la lista
                    if (areasAgregadas.length === 0) {
                        areasSeleccionadas.find('li').each(function() {
                            var areaAgregadaId = $(this).data('area-id');
                            areasAgregadas.push(areaAgregadaId);
                        });
                    }

                    console.log('Áreas agregadas:', areasAgregadas);

                    if (areaId === "") {
                        toastr.error('¡Por favor seleccione una área!', 'Error');
                        return;
                    }

                    console.log('Área seleccionada:', areaId);

                    // Si el área seleccionada ya está en la lista de selección
                    if (areasAgregadas.includes(parseInt(areaId))) {
                        toastr.error('¡Esta área ya fue agregada!', 'Error');
                        return;
                    }

                    // Si no hay problemas, agregar el área a la lista
                    areasSeleccionadas.append('<li class="list-group-item" data-area-id="' + areaId + '">' + areaNombre + '<button type="button" class="btn btn-danger btn-sm float-end btn-quitar-area" data-grupo="' + modalId + '" data-area="' + areaId + '"><i class="fas fa-times"></i></button></li>');

                    // Agregar el input oculto al formulario específico
                    $('#form-agregar-areas' + modalId).append('<input type="hidden" name="areas[]" value="' + areaId + '">');

                    toastr.success('Área agregada correctamente', 'Éxito');
                });
                        


                    // Eliminar área seleccionada
                    $(document).on('click', '.btn-danger', function () {
                        var modalId = $(this).closest('ul').attr('id').split('_').pop();
                        var listItem = $(this).closest('li');
                        var areaId = $(listItem).find('input[type="hidden"]').val(); // Obtener el valor del input oculto dentro del listItem
                        if (!areaId) {
                            areaId = listItem.data('area-id'); // Intentar obtener el área id desde el atributo de datos
                        }
                        listItem.remove();
                        $('#form-agregar-areas' + modalId).find('input[value="' + areaId + '"]').remove(); // Remover el input del formulario
                        
                    });

                // Manejar el envío del formulario para guardar áreas
                $('[id^=form-agregar-areas]').submit(function (event) {
                    event.preventDefault();

                    var formData = $(this).serialize();

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        success: function (response) {
                            
                            window.location.href = "{{ route('create.grupo') }}"; 
                        },
                        error: function (xhr, status, error) {
                            alert('Error al guardar las áreas');
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
    </script>

    <script>
        $(document).ready(function () {

            // Eliminar área seleccionada
            $(document).on('click', '#eliminar_areas', function () {
                
                var boton = $(this); // Almacenar una referencia al botón
                var grupoId = boton.data('grupo');
                var areaId = boton.data('area');

                // Obtener el elemento ul por su id
                var lista = $('#areas_seleccionadas_' + grupoId);

                // Contar el número de áreas
                var totalItems = lista.find('.list-group-item').length; // Busca elementos con la clase 'list-group-item'

                // Mostrar el total en la consola para verificar
                console.log("hay:", totalItems);

                // Validar si hay solo dos áreas y mostrar mensaje de error si es así
                if (totalItems <= 2) {
                    toastr.error('No se puede eliminar el área porque se necesitan al menos dos áreas para un grupo.', 'Error');
                    return; // Salir de la función si hay solo dos áreas
                }
               

                // Eliminar el área del grupo
                $.ajax({
                    type: 'POST',
                    url: "{{ route('eliminar_area') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        grupo_id: grupoId,
                        area_id: areaId
                    },
                    success: function (response) {
                        // Verificar si hay solo dos o menos áreas después de la eliminación
                    var totalItems = lista.find('.list-group-item').length;
                    if (totalItems <= 2) {
                        toastr.error('No se puede eliminar el área porque se necesitan al menos dos áreas para un grupo.', 'Error');
                    } else {
                        // Quitar el área de la lista solo si quedan más de dos áreas
                        boton.closest('li').remove(); // Usar la referencia al botón
                        toastr.success('Se eliminó el área', 'Éxito');
                    }

                    },
                    error: function (xhr, status, error) {
                        alert('Error, no eliminado')
                        console.error(xhr.responseText);
                    }
                });
                
            });

            });
    </script>

@endsection

