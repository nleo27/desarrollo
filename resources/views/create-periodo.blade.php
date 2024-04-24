@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title">Crear Nuevo periodo</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-periodo">Registrar Nuevo periodo</button>
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

                    
                        <tr>
                            <td>01</td>
                            <td>Nuevo Periodo</td>
                            <td>2023-2026</td>
                            
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-editar-area"><i class="fas fa-edit"></i> Editar</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-eliminar-area"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                   
                        
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
        <form id="form-registrar-periodo">
          <div class="form-group">
            <label for="nombre-periodo">Nombre del Periodo:</label>
            <input type="text" class="form-control" id="nombre-periodo" name="nombre_periodo">
          </div>
          <div class="form-group">
            <label for="descripcion-periodo">Descripción del Periodo:</label>
            <textarea class="form-control" id="descripcion-periodo" name="descripcion_periodo" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="fecha-inicio">Fecha de Inicio:</label>
            <input type="date" class="form-control" id="fecha-inicio" name="fecha_inicio">
          </div>
          <div class="form-group">
            <label for="fecha-fin">Fecha de Fin:</label>
            <input type="date" class="form-control" id="fecha-fin" name="fecha_fin">
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="periodo-activo" name="periodo_activo">
            <label class="form-check-label" for="periodo-activo">Periodo Activo</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-guardar-periodo">Guardar</button>
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
@endsection

