@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('title', 'Compartir grupos')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .wrapper{
            width: 100%
            
        }

        .box{
            max-width: 100%;
            background: #F6F6F6;
            padding: 30px;
            width: 100%;
            border-radius: 5px;
        }

        .upload-area-title{
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
        }

        .uploadlabel{
            width: 100%;
            min-height: 100px;
            background: #18a7ff0d;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 3px dashed #18a7ff82;
            cursor: pointer;
        }
        .uploadlabel span{
            font-size: 70px;
            color: #18a7ff;
        }

        .uploadlabel p{
            color: #18a7ff;
            font-size: 20px;
            font-weight: 800;
            font-family: cursive;
        }

        .uploaded{
            margin: 30px 0;
            font-size: 16px;
            font-weight: 700;
            color: #a5a5a5;
        }

        .showfilebox {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 10px 0;
        padding: 10px 15px;
        box-shadow: #0000000d 0px 0px 0px 1px, #d1d5db3d 0px 0px 0px 1px inset;
        } 

        .showfilebox .left {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        }

        .filetype{
        background: #18a7ff;
        color: #fff;
        padding: 5px 15px;
        font-size: 20px;
        text-transform: capitalize;
        font-weight: 700;
        border-radius: 3px;
        }
        .left h3{
        font-weight: 600;
        font-size: 18px;
        color: #292f42;
        margin:0;
        }
        .right span{
        background: #18a7ff;
        color: #fff;
        width: 25px;
        height: 25px;
        font-size: 25px;
        line-height: 25px;
        display: inline-block;
        text-align: center;
        font-weight: 700;
        cursor: pointer;
        border-radius: 50%;
        }
    </style>

    <div class="content-header">     
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">COMPARTIR ARCHIVOS EN EL GRUPO</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">

                        @if(isset($grupoId))
                        <div class="card-tools mr-1">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-documento"><i class="fas fas fa-file-upload"></i> Agregar Documento</button>
                        </div>
                        @endif

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <hr>
    
        @if(isset($grupoId))
        <!-- Tabla de lista de archivos -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center table-hover" id="lista-archivos">
                        <!-- Encabezados de la tabla -->
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Ruta</th>
                                <th>Grupo_Id</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <!-- Cuerpo de la tabla -->
                        <tbody>
                            <!-- Aquí puedes iterar sobre los archivos y mostrarlos -->
                        </tbody>
                    </table>
                </div>
            </div>
        @else
    
        <!-- Mensaje de que el área no pertenece a ningún grupo -->
        <div class="alert alert-warning">{{ $mensaje }}</div>
        @endif

    <!-- Modal Registrar Documentos -->
    <div class="modal fade" id="modal-registrar-documento">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><i class="fas fas fa-file-upload"></i> Registrar Documentos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario principal -->
                    <form action="{{ route('archivo-grupo.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <input type="text" class="form-control" id="grupo_id" name="grupo_id" value="{{ $grupoId }}" hidden>
                        
                        <div class="form-group">
                            <label for="nombre_archivo">Nombre del Documento</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="nombre_archivo" name="nombre_archivo" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fas fa-file-upload"></i></span>
                                </div>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        <div class="wrapper">
                            <div class="box">
                                <div class="input-bx">
                                    <h2 class="upload-area-title">Subir Archivos</h2>
                                
                                        <input type="file" id="upload" name="upload[]" accept=".doc, .docx, .pdf, .jpeg, .png, .jpg" multiple hidden>
                                        <label for="upload" class="uploadlabel">
                                            <span><i class="fas fa-upload"></i></span>
                                            <p> Haz click para subir tus archivos</p>
                                        </label>
                                </div>
        
                                <div id="filewrapper">
                                    <h3 class="uploaded">Documentos subidos</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Crear Archivo</button>
                        </div>
                    </form>
                    <!-- Fin del formulario principal -->

                
                </div>
                <script>
                    window.addEventListener("load",()=>{
                        const input = document.getElementById("upload");
                        const filewrapper = document.getElementById("filewrapper");
                
                        input.addEventListener("change",(e)=>{
                            for (const file of e.target.files) {
                                let fileName = file.name;
                                let filetype = fileName.split(".").pop();
                                fileshow(fileName, filetype);
                            }
                        })
                
                        const fileshow=(fileName, filetype)=>{
                            const showfileboxElem= document.createElement("div");
                            showfileboxElem.classList.add("showfilebox");
                            const leftElem = document.createElement("div");
                            leftElem.classList.add("left");
                            const fileTypeElem = document.createElement("span");
                            fileTypeElem.classList.add("filetype");
                            fileTypeElem.innerHTML = filetype;
                            leftElem.append(fileTypeElem);
                            const filetitleElem = document.createElement("h3");
                            filetitleElem.innerHTML=fileName;
                            leftElem.append(filetitleElem);
                            showfileboxElem.append(leftElem);
                            const rightElem = document.createElement("div");
                            rightElem.classList.add("right");
                            showfileboxElem.append(rightElem);
                            const crossElem = document.createElement("span");
                            crossElem.innerHTML="&#215;";
                            rightElem.append(crossElem);
                            filewrapper.append(showfileboxElem);
                
                            crossElem.addEventListener("click", ()=>{
                                filewrapper.removeChild(showfileboxElem);
                            })
                        }
                
                    })
                </script>
            </div>
        </div>
    </div>

      <!-- Modal para visualizar archivos -->
      <div class="modal fade" id="ver_archivo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fas fa-file-upload"></i> Detalle de Archivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align: center" id="modal-body-content">
                        <div id="archivo-info"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para eliminar-->
        <div class="modal fade" id="eliminar-archivos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="eliminarModalLongTitle"><i class="fas fa-trash-alt"></i> Eliminar archivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body-eliminar">
                        <!-- Contenido se actualizará dinámicamente -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" id="confirmar-eliminar">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Documentos -->
    <div class="modal fade" id="modal-editar-documento">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><i class="fas fas fa-file-upload"></i> Editar Documentos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario principal -->
                    <form id="edit-form" action="" method="POST" enctype="multipart/form-data">

                       
                        <input type="text" class="form-control" id="grupo_id" name="grupo_id" value="{{ $grupoId }}">
                        
                        <div class="form-group">
                            <label for="edit_archivo">Nombre del Documento</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="edit_archivo" name="edit_archivo" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fas fa-file-upload"></i></span>
                                </div>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label for="edit_descripcion">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" name="edit_descripcion" rows="3"></textarea>
                        </div>

                        <div class="wrapper">
                            <div class="box">
                                <div class="input-bx">
                                    <h2 class="upload-area-title">Subir Archivos</h2>
                                
                                        <input type="file" id="upload" name="upload[]" accept=".doc, .docx, .pdf, .jpeg, .png, .jpg" multiple hidden>
                                        <label for="upload" class="uploadlabel">
                                            <span><i class="fas fa-upload"></i></span>
                                            <p> Haz click para subir tus archivos</p>
                                        </label>
                                </div>
        
                                <div id="edit-filewrapper">
                                    <h3 class="uploaded">Documentos subidos</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="btn-update" class="btn btn-primary">Actualizar Archivo</button>
                        </div>
                    </form>
                    <!-- Fin del formulario principal -->

                
                </div>
                <script>
                       window.addEventListener("load", () => {
                            const input = document.getElementById("upload");
                            const filewrapper = document.getElementById("edit-filewrapper");

                            input.addEventListener("change",(e)=>{
                                for (const file of e.target.files) {
                                let fileName = file.name;
                                let filetype = fileName.split(".").pop();
                                fileshow(fileName, filetype);
                                }
                            })

                            const fileshow=(fileName, filetype)=>{
                            const showfileboxElem= document.createElement("div");
                            showfileboxElem.classList.add("showfilebox");
                            const leftElem = document.createElement("div");
                            leftElem.classList.add("left");
                            const fileTypeElem = document.createElement("span");
                            fileTypeElem.classList.add("filetype");
                            fileTypeElem.innerHTML = filetype;
                            leftElem.append(fileTypeElem);
                            const filetitleElem = document.createElement("h3");
                            filetitleElem.innerHTML=fileName;
                            leftElem.append(filetitleElem);
                            showfileboxElem.append(leftElem);
                            const rightElem = document.createElement("div");
                            rightElem.classList.add("right");
                            showfileboxElem.append(rightElem);
                            const crossElem = document.createElement("span");
                            crossElem.innerHTML="&#215;";
                            rightElem.append(crossElem);
                            filewrapper.append(showfileboxElem);
                
                            crossElem.addEventListener("click", ()=>{
                                filewrapper.removeChild(showfileboxElem);
                            })
                        }
                        });
                </script>
            </div>
        </div>
    </div>

@endsection

@section('js')

<!--<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



<script>
   $(document).ready(function() {
    
        $('#lista-archivos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('archivo-grupo.getArchivos') }}",
            "columns": [
                { data: 'id' },
                { data: 'nombre' },
                { data: 'ruta_archivo',
                    render: function(data, type, row) {
                        var extension = data.split('.').pop().toLowerCase();
                        var icono = '';

                        if (extension === 'png' || extension === 'jpg' || extension === 'jpeg') {
                            icono = '<img src="{{ url("/imagenes/iconos/imagen01.png") }}" width="25px">';
                        } else if (extension === 'pdf') {
                            icono = '<img src="{{ url("/imagenes/iconos/pdf.png") }}" width="25px">';
                        } else if (extension === 'docx' || extension === 'doc') {
                            icono = '<img src="{{ url("/imagenes/iconos/palabra.png") }}" width="25px">';
                        } else if (extension === 'xlsx') {
                            icono = '<img src="{{ url("/imagenes/iconos/excel.png") }}" width="25px">';
                        }

                        return icono + data;
                    } },
                { data: 'grupo_area_id' },
                { data: 'descripcion'},
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="accionesButton${data.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opciones
                                </button>
                                <div class="dropdown-menu" aria-labelledby="accionesButton${data.id}">
                                    <a href="#" class="dropdown-item ver-archivo" data-toggle="modal" data-target="#ver_archivo_modal" data-info='${JSON.stringify(data)}'><i class="fas fa-eye text-info"></i> Ver</a>
                                    <a href="#" class="dropdown-item editar-archivo" data-toggle="modal" data-target="#modal-editar-documento" data-inform='${JSON.stringify(data)}'><i class="fas fa-edit text-warning"></i> Editar</a>
                                    <a href="#" class="dropdown-item eliminar-archivo" data-toggle="modal" data-target="#eliminar-archivos" data-informacion='${JSON.stringify(data)}'><i class="fas fa-trash-alt text-danger"></i>Eliminar</a>
                                    <a href="{{ asset('storage/Grupo_${data.grupo_area_id}/${data.ruta_archivo}') }}" class="dropdown-item" download><i class="fas fa-file-download text-secondary"></i> Descargar</a>
                              
                                </div>
                            </div>
                        `;
                    }
                }
                // Agrega más columnas según tu modelo de datos
            ],
            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "Nada encontrado - disculpa",
                "info": "Estás en la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar"
            }
        });
    });

        
    // Evento de clic para abrir el modal
        $('#lista-archivos').on('click', '.ver-archivo', function() {
        
            var archivoData = $(this).data('info');
            
                  
            // Actualizar el título del modal
            $('#exampleModalLongTitle').text(archivoData.nombre);

            // Obtener la extensión del archivo después de que se ha construido el HTML
            var nombreArchivo = archivoData.ruta_archivo;
            
            var extension = nombreArchivo.split('.').pop().toLowerCase();
            
            // Limpiar el contenido anterior del cuerpo del modal
            $('#modal-body-content').empty();

            // Mostrar la información del archivo en el cuerpo del modal
            var modalBodyContent = '';

            if (extension === "png" || extension === "jpg" || extension === "jpeg") {
                modalBodyContent += `<img src="${archivoData.url}" width="100%" alt="Imagen">`;
            } else if (extension === "pdf") {
                modalBodyContent += '<iframe src="' + archivoData.url + '" width="100%" height="420px"></iframe>';
            } else if (extension === "docx" || extension === "doc") {
                modalBodyContent += '<img src="{{asset("imagenes/iconos/palabra.png")}}" width="20%"><br><br>';
                modalBodyContent += '<a href="' + archivoData.url + '" class="btn btn-success btn-lg mb-1"><i class="fas fa-file-download"></i> Descargar</a>';
            } else if (extension === "xlsx") {
                modalBodyContent += '<img src="{{asset("imagenes/iconos/excel.png")}}" width="20%"><br><br>';
                modalBodyContent += '<a href="' + archivoData.url + '" class="btn btn-success btn-lg mb-1"><i class="fas fa-file-download"></i> Descargar</a>';
            }

            $('#modal-body-content').append(modalBodyContent);

            
        });

        // Evento de clic para abrir el modal y Eliminar
        $('#lista-archivos').on('click', '.eliminar-archivo', function() {
        var archivoData = $(this).data('informacion');
        
        // Limpiar el contenido anterior del cuerpo del modal
        $('#modal-body-eliminar').empty();

        // Mostrar la información del archivo en el cuerpo del modal
        var modalBodyContent = `<p>¿Desea eliminar el archivo: <strong>${archivoData.nombre}</strong>?</p>`;
        
        $('#modal-body-eliminar').append(modalBodyContent);

        // Guardar la información del archivo en un atributo de datos del botón de confirmación
        
        $('#confirmar-eliminar').data('archivo-id', archivoData.id);
        });

        // Evento de clic para confirmar la eliminación
        $('#confirmar-eliminar').on('click', function() {
            var archivoId = $(this).data('archivo-id');

            // Obtener el token CSRF
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Realizar la solicitud AJAX para eliminar el archivo
            $.ajax({
                url: '/eliminar-archivo-grupo/' + archivoId,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: csrfToken
                },
                success: function(response) {
                    toastr.success('Área Eliminada correctamente', 'Éxito');

                    window.location.href = "{{ route('archivo-grupo.create') }}"; 
                    
                    console.log(response);
                    // Cerrar el modal
                    $('#eliminar-archivos').modal('hide');
                    // Actualizar la lista de archivos si es necesario
                },
                error: function(xhr) {
                    // Manejar el error
                    console.log(xhr.responseText);
                }
            });
        });

        // Evento de clic para abrir el modal y editar
        $('#lista-archivos').on('click', '.editar-archivo', function() {
            var archivoData = $(this).data('inform');

            $('#edit_archivo').val(archivoData.nombre);
            $('#edit_descripcion').val(archivoData.descripcion);

            // Almacena los datos del archivo en el botón de actualización
            $('#btn-update').data('archivo', archivoData);
            
        });

        // Evento de clic para actualizar el archivo
        $('#btn-update').click(function() {
            var archivoData = $(this).data('archivo');
            var formData = new FormData();

            formData.append('edit_archivo', $('#edit_archivo').val());
            formData.append('edit_descripcion', $('#edit_descripcion').val());
            

            var files = $('#upload')[0].files;
            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    formData.append('upload[]', files[i]);
                }
            }

            console.log([...formData.entries()]);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: "/archivo-grupo/" + archivoData.id,
                type: 'POST',
                data: formData,
                headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                contentType: false,
                processData: false,

                success: function(response) {
                    toastr.success('Archivo Actualizado Correctament', 'Éxito');
                    window.location.href = "{{ route('archivo-grupo.create') }}"; 
                },
                error: function(xhr, status, error) {
                    // Captura el mensaje de error exacto del servidor
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Error desconocido";
                    
                    // Si hay más detalles en la respuesta de error, también captúralos
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += ' ' + errors[key].join(' ');
                            }
                        }
                    }
                    
                                 
                    // Traduce el mensaje de error
                    var translatedErrorMessage = translateErrorMessage(errorMessage);
                    toastr.error(translatedErrorMessage, 'Error');
                }
            });

            function translateErrorMessage(message) {
    var translations = {
        "Forbidden": "Prohibido",
        "The edit archivo field is required": "El archivo del nombre es requerido, no puedes enviar vacío",
        "The upload.0 field must not be greater than 3072 kilobytes.": "El archivo no debe ser mayor de 3 Megas.",
        "The upload.0 field must be a file of type: doc, docx, pdf, jpeg, png, jpg.": "El archivo debe ser de tipo: doc, docx, pdf, jpeg, png, jpg."
        // Agrega más traducciones según sea necesario
    };

    // Intenta encontrar una traducción exacta
    if (translations[message]) {
        return translations[message];
    }
    
    // Búsqueda de traducciones parciales si el mensaje contiene detalles adicionales
    for (var key in translations) {
        if (message.includes(key)) {
            return translations[key];
        }
    }

    // Si no hay traducción, devuelve el mensaje original
    return message;
}
        });

    
</script>

   

@endsection