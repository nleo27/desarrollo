@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Buscador')

@section('content')
    <div class="card mt-5">
        <div class="card-header ">
            <h3 class="card-title">Buscador de Archivos</h3>
            
            
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <!-- Filtro por periodo -->
                <div class="col-md-3">
                    <label for="periodo" class="form-label">Periodo</label>
                    <select id="periodo" class="form-control">
                        <!-- Si el usuario es Administrador -->
                        @if($role == 'Administrador')
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                            @endforeach
                        @else
                            <!-- Si el usuario no es Administrador, solo mostrar el periodo activo -->
                            @foreach($periodos as $periodo)
                                @if($periodo->periodo_activo == 1)
                                    <option value="{{ $periodo->id }}" selected>{{ $periodo->nombre }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    <button class="btn btn-primary mt-2" type="button" id="btnBuscarPeriodo">Buscar Periodo</button>
                </div>
        
                <!-- Filtro por rango de fechas -->
                <div class="col-md-3">
                    <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                    <input type="date" id="fechaInicio" class="form-control">
                    
                </div>
                <div class="col-md-3">
                    <label for="fechaFin" class="form-label">Fecha Fin</label>
                    <input type="date" id="fechaFin" class="form-control">
                    <button class="btn btn-primary mt-2" type="button" id="btnBuscarFechaFin">Buscar rango de Fecha</button>
                </div>
        
                <!-- Input de búsqueda -->
                <div class="col-md-3">
                    <label for="buscar" class="form-label">Buscar</label>
                    <div class="input-group">
                        <input type="text" id="buscar" class="form-control" placeholder="Ingrese un término">
                        <button class="btn btn-primary" type="button" id="btnBuscarTexto">Buscar</button>
                    </div>
                </div>
            </div>
        
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-center" id="lista-buscador">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Archivo</th>
                            <th>Ruta</th>
                            <th>Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="archivosListado">
                        @foreach($archivos as $archivoArray)
                        @foreach($archivoArray as $archivo)
                            <tr>
                                <td>{{ $archivo->id }}</td>
                                <td>{{ $archivo->nombre_archivo }}</td>
                                <td>{{ $archivo->ruta }}</td>
                                <td>{{ $archivo->fecha_archivo }}</td>
                                <td>
                                    <button class="btn btn-primary">Ver</button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
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
    new DataTable('#lista-buscador',{
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
document.getElementById('btnBuscarPeriodo').addEventListener('click', function() {
    var periodoId = document.getElementById('periodo').value;
    
    // Enviar la solicitud AJAX para obtener los archivos filtrados por periodo
    fetch('/obtener/archivos?periodo=' + periodoId, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        var archivosListado = document.getElementById('archivosListado');
        archivosListado.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos resultados

        // Verificar si los archivos existen y luego mostrarlos
        if (data && data.length > 0) {
            data.forEach(archivo => {
                archivosListado.innerHTML += `
                    <tr>
                        <td>${archivo.id}</td>
                        <td>${archivo.nombre_archivo}</td>
                        <td>${archivo.ruta || 'No disponible'}</td> <!-- Usar un valor predeterminado en caso de que no exista ruta -->
                        <td>${archivo.fecha_archivo}</td>
                        <td>
                            <button class="btn btn-primary">Ver</button>
                        </td>
                    </tr>
                `;
            });
        } else {
            archivosListado.innerHTML = '<tr><td colspan="5">No se encontraron archivos.</td></tr>';
        }
    })
    .catch(error => {
        console.error('Error al obtener los archivos:', error);
    });
});
</script>
@endsection

