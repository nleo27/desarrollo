@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .no-cartas-message {
            font-size: 24px;
            font-weight: bold;
            color: #FF5733; /* Puedes cambiar el color si lo deseas */
            text-align: center;
            margin-top: 20px;
        }
    </style>
@endsection

@section('title', 'Lista Cartas')

@section('content')
    <div class="card mt-5">
        <div class="card-header ">
            <h3 class="card-title">Listado de cartas</h3>

            
                        
        </div>

        <!-- Verifica si hay un mensaje de "sin cartas" -->
    @if ($noCartasMessage)
    <p class="no-cartas-message">{{ $noCartasMessage }}</p>
    @else

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-cartas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Dirigido a</th>
                            <th>Institución</th>
                            <th>Asunto</th>
                            <th>Requerimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartas as $index => $carta)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $carta->nombre_carta }}</td>
                            <td>{{ $carta->fecha_carta }}</td>
                            <td>{{ $carta->dirigido }}</td>
                            <td>{{ $carta->institucion }}</td>
                            <td>{{ $carta->asunto }}</td>
                            <td>
                                <a href="{{ route('cartas.show', ['carta' => $carta->id]) }}" class="btn btn-warning">Ver Carta</a>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#requerimientoModal" onclick="mostrarRequerimientos({{ $carta->id }})">Ver requerimiento</a>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                 <!-- Modal -->
                 <div class="modal fade" id="requerimientoModal" tabindex="-1" role="dialog" aria-labelledby="requerimientoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document"> <!-- Cambiado a modal-lg para mayor ancho -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requerimientoModalLabel">Requerimientos de la Carta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modal-body-requerimientos">
                                <!-- Los requerimientos se cargarán aquí con JavaScript -->
                                Cargando requerimientos...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif

              
        
        
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
        new DataTable('#lista-cartas',{
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
    function mostrarRequerimientos(cartaId) {
    // Hacer una solicitud AJAX para obtener los requerimientos de la carta
    $.ajax({
        url: '/cartas/' + cartaId + '/requerimientos', // La ruta que devuelve los requerimientos
        method: 'GET',
        success: function (response) {
            let requerimientosHTML = '';

            // Verifica si hay requerimientos
            if (response.requerimientos.length > 0) {
                response.requerimientos.forEach(function (requerimiento) {
                    // Mostrar datos del requerimiento
                    requerimientosHTML += `
                        <div>
                            <p><strong>Requerimiento:</strong> ${requerimiento.texto_requerimiento}</p>
                            <p><strong>Fecha de Inicio:</strong> ${requerimiento.fecha_inicio}</p>
                            <p><strong>Fecha de Fin:</strong> ${requerimiento.fecha_fin}</p>
                            <p><strong>Dirigido a:</strong> ${requerimiento.dirigido}</p>
                            <p><strong>Archivos:</strong></p>
                    `;

                    // Mostrar archivos si existen
                    if (requerimiento.archivos.length > 0) {
                        requerimiento.archivos.forEach(function (archivo) {
                            requerimientosHTML += `
                                
                                <div style="text-align: center; color: blue; background-color: #f0f8ff; padding: 5px; border-radius: 5px;">
                                    <p><strong>Se ha encontrado archivos</strong></p>

                                    <div>
                                    <a href="/storage/${archivo}" target="_blank" class="btn btn-sm btn-success">Ver archivo</a>
                                    <a href="/storage/${archivo}" download class="btn btn-sm btn-primary">Descargar</a>
                                    </div>
                                </div>
                                
                            `;
                        });
                    } else {
                        // Si no hay archivos
                        requerimientosHTML += `
                        <p style="text-align: center; color: red; font-weight: bold; background-color: #ffe6e6; padding: 10px; border-radius: 5px;">
                            Aún no han adjuntado archivos para este requerimiento.
                        </p>`;
                    }

                    requerimientosHTML += '<hr></div>';
                });
            } else {
                // Si no hay requerimientos
                requerimientosHTML = '<p>No hay requerimientos para esta carta.</p>';
            }

            // Mostrar los requerimientos en el cuerpo del modal
            $('#modal-body-requerimientos').html(requerimientosHTML);
        },
        error: function () {
            // En caso de error, mostrar mensaje
            $('#modal-body-requerimientos').html('<p>Ocurrió un error al cargar los requerimientos.</p>');
        }
    });
}
</script>


    

@endsection

