@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Periodo')
  


@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title">Crear Nuevo periodo</h3>
            @can('create_periodo.create')

            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-periodo">Registrar Nuevo periodo</button>
            </div>
                
            @endcan
            
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-periodo">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->id }}</td>
                            <td>{{ $periodo->nombre }}</td>
                            <td>{{ $periodo->descripcion }}</td>
                            <td>{{ $periodo->fecha_inicio }}</td>
                            <td>{{ $periodo->fecha_fin }}</td>
                            
                            
                            <td>
                            <a href="{{ route('seleccionar-periodo', ['id' => $periodo->id]) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Seleccionar</a>
                            
                            @can('create_periodo.eliminar')

                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminar-area"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                
                            @endcan
                                
                            </td>
                   
                    @endforeach     
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Periodo -->
    <div class="modal fade" id="modal-registrar-periodo" tabindex="-1" role="dialog" aria-labelledby="modal-registrar-periodo" aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-registrar-periodo-title">Registrar Periodo de Alcaldía</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-registrar-periodo" action="{{ route('periodo.create2') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nombre-periodo">Nombre del Periodo:</label>
                                    <input type="text" class="form-control" id="nombre-periodo" name="nombre_periodo" required>
                                    <span id="nombre-error" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion-periodo">Descripción del Periodo:</label>
                                    <textarea class="form-control" id="descripcion-periodo" name="descripcion_periodo" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="fecha-inicio">Fecha de Inicio:</label>
                                    <input type="date" class="form-control" id="fecha-inicio" name="fecha_inicio" required>
                                    <span id="fecha_inicio-error" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="fecha-fin">Fecha de Fin:</label>
                                    <input type="date" class="form-control" id="fecha-fin" name="fecha_fin" required>
                                    <span id="fecha_fin-error" class="text-danger"></span>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="periodo-activo" name="periodo_activo" value="1">
                                    <label class="form-check-label" for="periodo-activo">Periodo Activo</label>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="btn-guardar-periodo">Guardar</button>
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
    new DataTable('#lista-periodo',{
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



<script src="{{ asset('js/validar-periodo.js') }}"></script>

@endsection

