@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('title', 'Notificaciones')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('0f9a8ae710a50db568cb', {
        cluster: 'us2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('form-submitted', function(data) {
        alert(JSON.stringify(data));
        });
    </script>

@section('content')

    <div class="card mt-5">
        <div class="card-header">
            <h3 class="card-title"><strong>Notificacionesxxxxxxx</strong></h3>
        </div>

    <!-- Mostrar las cartas dirigidas al usuario -->
    <h2>Cartas Recibidas</h2>
    @if($cartas->isEmpty())
        <p style="text-align: center; color: red;">No tienes cartas nuevas.</p>
    @else
        <div class="card-body">
            <div class="table-responsive">    
                <table class="table table-bordered table-striped text-center" id="cartas-recibidas">
                    <thead>
                        <tr>
                            <th>Nombre de la Carta</th>
                            <th>Fecha</th>
                            <th>Institución</th>
                            <th>Asunto</th>
                            <th>Fecha de Caducidad</th>
                            <th>Requerimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartas as $carta)
                            <tr>
                                <td>{{ $carta->nombre_carta }}</td>
                                <td>{{ $carta->fecha_carta }}</td>
                                <td>{{ $carta->institucion }}</td>
                                <td>{{ $carta->asunto }}</td>
                                <td>{{ $carta->fecha_caduca }}</td>
                                
                                <td>
                                    <!-- Aquí ya no es necesario el data-toggle y data-target -->
                                
                                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#requerimientoModal" onclick="verRequerimiento({{ $carta->id }})">Ver requerimiento</a>
                                    
                                    
                                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#verDocumento" onclick="cargarArchivos({{ $carta->id }})">Ver adjuntos</a>
                                    
                                </td>
                                

                            </tr>
                        @endforeach

                    
                    </tbody>
                </table>
            </div>
        </div>

                <!-- Modal para mostrar requerimientos -->
                <div class="modal fade" id="requerimientoModal" tabindex="-1" role="dialog" aria-labelledby="requerimientoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="requerimientoModalLabel">Requerimientos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body" id="requerimientosContent">
                        <!-- Aquí se cargarán los requerimientos -->
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                    </div>
                </div>

            <!-- Modal -->
            <div class="modal fade" id="verDocumento" tabindex="-1" role="dialog" aria-labelledby="verDocumentoLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verDocumentoLabel">Archivos Adjuntos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="archivosAdjuntos">
                            <!-- Los archivos adjuntos se cargarán aquí -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>



               
                        
        </div>
    @endif

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>

    <script>
        new DataTable('#cartas-recibidas',{
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
        function verRequerimiento(cartaId) {
            // Realizar una solicitud AJAX para obtener los requerimientos
            $.ajax({
                url: '/cartas/' + cartaId + '/requerimientos', // Asegúrate de que esta URL esté bien configurada
                method: 'GET',
                success: function(response) {
                    // Mostrar los requerimientos en el modal
                    let requerimientosHtml = '';
                    if (response.requerimientos.length > 0) {
                        response.requerimientos.forEach(requerimiento => {
                            requerimientosHtml += `
                            <div>
                                <p><strong>Requerimiento:</strong> ${requerimiento.texto_requerimiento}</p>
                                <p><strong>Fecha de Inicio:</strong> ${requerimiento.fecha_inicio}</p>
                                <p><strong>Fecha de Fin:</strong> ${requerimiento.fecha_fin}</p>
                                <p><strong>Dirigido a:</strong> ${requerimiento.dirigido}</p>
                                <hr>
                                <!-- Formulario para subir archivo -->
                                <form id="uploadForm-${requerimiento.id}" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="archivo-${requerimiento.id}" class="form-label">Subir Archivo:</label>
                                        <input class="form-control" type="file" id="archivo-${requerimiento.id}" name="archivo" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpeg,.jpg,.png,.avif">
                                    </div>
                                    <div class="mb-3">
                                        <label for="observaciones-${requerimiento.id}" class="form-label">Observaciones:</label>
                                        <textarea class="form-control" id="observaciones-${requerimiento.id}" name="observaciones"></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="guardarArchivo(${requerimiento.id})">Guardar</button>
                                </form>
                            </div>
                            <hr>
                            
                            `;  // Ajusta según el campo que tiene el requerimiento
                        });
                    } else {
                        requerimientosHtml = '<p>No hay requerimientos para esta carta.</p>';
                    }
    
                    // Actualizar el contenido del modal
                    $('#requerimientosContent').html(requerimientosHtml);
    
                    // Mostrar el modal usando JavaScript (Bootstrap 5)
            var myModal = new bootstrap.Modal(document.getElementById('requerimientoModal'));
            myModal.show();
                },
                error: function() {
                    alert('Error al obtener los requerimientos.');
                }
            });
        }
    </script>

        <script>
            toastr.options = {
                "closeButton": true, // Muestra un botón de cierre en la notificación
                "debug": false,
                "newestOnTop": true,
                "progressBar": true, // Muestra una barra de progreso
                "positionClass": "toast-top-right", // Posición de la notificación
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300", // Duración de la animación de aparición
                "hideDuration": "500", // Duración de la animación de desaparición
                "timeOut": "2000", // Tiempo que la notificación permanece visible
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        </script>

    <script>

        function guardarArchivo(requerimientoId) {
            var formData = new FormData();
            var archivoInput = document.getElementById(`archivo-${requerimientoId}`);
            var observaciones = document.getElementById(`observaciones-${requerimientoId}`).value;

            if (archivoInput.files.length === 0) {
                toastr.error('Por favor, selecciona un archivo.');
                return;
            }

            var archivo = archivoInput.files[0];
            var tiposPermitidos = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'image/jpeg',
                'image/png',
                'image/avif'
            ];

            // Validar el tipo de archivo
            if (!tiposPermitidos.includes(archivo.type)) {
                toastr.error('El tipo de archivo es incorrecto. Solo se permiten archivos Word, Excel, PowerPoint, JPEG, JPG, PNG, PDF y AVIF.');
                return;
            }

            // Validar el tamaño del archivo (máximo 3 MB)
            var tamañoMaximoMB = 3;
            if (archivo.size > tamañoMaximoMB * 1024 * 1024) {
                toastr.error('El tamaño del archivo excede el límite de 3 MB. Por favor, selecciona un archivo más pequeño.');
                return;
            }

            // Verificar si ya existe un archivo subido para este requerimiento
            $.ajax({
                url: `/requerimientos/${requerimientoId}/verificar-archivo`, // Ruta para verificar el archivo
                method: 'GET',
                success: function(response) {
                   
                    // Proceder con la subida del archivo
                    formData.append('archivo', archivoInput.files[0]);
                    formData.append('observaciones', observaciones);
                    formData.append('_token', '{{ csrf_token() }}'); // Asegúrate de que el token CSRF esté disponible

                    $.ajax({
                        url: `/requerimientos/${requerimientoId}/subir-archivo`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            toastr.success(response.mensaje); // Mostrar mensaje de éxito con Toastr
                            // Opcional: cerrar el modal después de guardar
                            var myModalEl = document.getElementById('requerimientoModal');
                            var modal = bootstrap.Modal.getInstance(myModalEl);
                            modal.hide();
                        },
                        error: function(xhr) {
                            toastr.error('Ocurrió un error al subir el archivo.');
                        }
                    });
                },
                error: function() {
                    toastr.error('Error al verificar si ya existe un archivo.');
                }
            });
        }
    </script>

<script>
function cargarArchivos(idCarta) {
    fetch(`/obtener-archivos/${idCarta}`)
        .then(response => response.json())
        .then(data => {
            const modalBody = document.getElementById('archivosAdjuntos');
            modalBody.innerHTML = ''; // Limpiar contenido previo

            if (data.length > 0) {
                data.forEach(archivo => {
                    // Verificar la extensión del archivo
                    const extension = archivo.extension.toLowerCase();
                    let contenido = `<p>Archivo: ${archivo.nombre}</p>`;

                    // Si es un PDF, mostrar un visor
                    if (['pdf'].includes(extension)) {
                        contenido += `<embed src="${archivo.archivo}" type="application/pdf" width="100%" height="400px" />`;
                    }
                    // Si es una imagen (JPEG, PNG, JPG, etc.), mostrar un visor de imagen
                    else if (['jpeg', 'png', 'jpg', 'gif'].includes(extension)) {
                        contenido += `<img src="${archivo.archivo}" width="100%" height="auto" />`;
                    }
                    // Si es un archivo de Excel, Word o PowerPoint, mostrar solo el visor
                    else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(extension)) {
                        
                    }
                    
                    // Siempre agregar el botón de descarga
                    contenido += `<a href="${archivo.archivo}" class="btn btn-success" download>Descargar</a>`;

                    // Añadir el contenido generado al modal
                    modalBody.innerHTML += contenido;
                });
            } else {
                modalBody.innerHTML = '<p>No hay archivos adjuntos para esta carta.</p>';
            }
        })
        .catch(error => {
            console.error('Error al cargar los archivos:', error);
        });
}
</script>

@endsection