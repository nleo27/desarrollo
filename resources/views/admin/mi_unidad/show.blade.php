@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Carpetas')

@section('content')

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    

    <div class="content-header">     
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$carpeta->nombre}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <div class="card-tools mr-3">
                            <a href="{{url('/admin/mi_unidad')}}" class="btn btn-success"><i class="fas fa-solid fa-folder-open"></i>  Mi Unidad</a>
                        </div>

                        <div class="card-tools mr-3">
                            <a href="#" onclick="history.back();" class="btn btn-danger">
                                <i class="far fa-regular fa-hand-point-left"></i>  Regresar
                            </a>
                        </div>

                        <div class="card-tools mr-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-registrar-documento"><i class="fas fas fa-file-upload"></i> Registrar Documento</button>
                        </div>

                        <div class="card-tools">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-registrar-archivador"><i class="fas fa-solid fa-folder-plus"></i> Registrar Archivador</button>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Documentos -->
<div class="modal fade" id="modal-registrar-documento">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registrar Documentos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                
                <!-- Área de Dropzone -->
                <form action="{{ url('/admin/mi_unidad/upload-and-create') }}" method="POST" class="dropzone" id="myDropzone" enctype="multipart/form-data">
                    @csrf
                    <input type="text" value="{{ $carpeta->id }}" name="id" hidden>
                    <div class="fallback">
                        <input type="file" name="file" multiple>
                    </div>
                </form>
                <!-- Fin del área de Dropzone -->

                <!-- Formulario principal -->
                <form action="{{ url('/admin/mi_unidad/upload-and-create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{ $carpeta->id }}" name="carpeta_padre_id" hidden>
                    </div>
                    <div class="form-group">
                        <label for="nombre_archivo">Nombre del Documento</label>
                        <input type="text" class="form-control" id="nombre_archivo" name="nombre_archivo" required>
                    </div>
                    <div class="form-group">
                        <label for="folios">N° Folios</label>
                        <input type="text" class="form-control" id="folios" name="folios">
                    </div>
                    <div class="form-group">
                        <label for="personal_dirigido">Personal Dirigido</label>
                        <input type="text" class="form-control" id="personal_dirigido" name="personal_dirigido">
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                     
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear Archivo</button>
                    </div>
                </form>
                <!-- Fin del formulario principal -->

               
            </div>
            <script>
                Dropzone.options.myDropzone = {

                    paramName: "file", // The name that will be used to transfer the file
                    dictDefaultMessage: "Arrastra y suelta el archivo o haz click aquí",
                    maxFilesize: 2, // MB
                };
            </script>
        </div>
    </div>
</div>

    <!-- Modal Registrar Archivador -->
    <div class="modal fade" id="modal-registrar-archivador">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Cambié modal-dialog a modal-lg para hacerlo más ancho -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Archivador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/admin/mi_unidad/carpeta')}}" method="get">
                        @csrf
                        <div class="form-group">
                            
                            <input type="text" class="form-control" value="{{$carpeta->id}}" name="carpeta_padre_id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre de Archivador</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" >
                        </div>
                        <div class="form-group">
                            <label for="estante">Estante</label>
                            <input type="text" class="form-control" id="estante" name="estante" >
                        </div>
                        <div class="form-group">
                            <label for="modulo">Módulo</label>
                            <input type="text" class="form-control" id="modulo" name="modulo" >
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" ></textarea>
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
    <hr>
    <h5>Carpetas y Archivos</h5>
    <hr>

    <div class="row">
        @foreach ($subcarpetas as $subcarpeta)
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{url('/admin/mi_unidad/carpeta', $subcarpeta->id)}}" class="info-box" style="text-decoration: none; box-shadow: none;color: inherit;">
                    <span class="info-box-icon bg-success"><i class="fas fa-folder"></i></span>
                    <div class="info-box-content" style="color: black;">
                        <span class="info-box-text">{{$subcarpeta->nombre}}</span>
                    </div>
                </a>
                <!-- Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-editar-archivador{{$subcarpeta->id}}">
                            <i class="fas fa-solid fa-pen"></i> Editar
                        </a>
                        <a class="dropdown-item" href="#" id="eliminar">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </div>
                </div>
                <!-- /Dropdown -->
            </div>

            <!-- Modal Editar Archivador -->
            <div class="modal fade" id="modal-editar-archivador{{$subcarpeta->id}}">
                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Cambié modal-dialog a modal-lg para hacerlo más ancho -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Editar Archivador</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('/admin/mi_unidad')}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" value="{{$subcarpeta->id}}" name="id" hidden >
                                <div class="form-group">
                                    <label for="nombre">Nombre de Archivador</label>
                                    <input type="text" class="form-control" value="{{$subcarpeta->nombre}}" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="codigo">Código</label>
                                    <input type="text" class="form-control" value="{{$subcarpeta->codigo}}" id="codigo" name="codigo" >
                                </div>
                                <div class="form-group">
                                    <label for="estante">Estante</label>
                                    <input type="text" class="form-control" value="{{$subcarpeta->estante}}" id="estante" name="estante" >
                                </div>
                                <div class="form-group">
                                    <label for="modulo">Módulo</label>
                                    <input type="text" class="form-control" value="{{$subcarpeta->modulo}}" id="modulo" name="modulo" >
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" >{{$subcarpeta->descipcion}}</textarea>
                                </div>
                                <div class="modal-footer"> <!-- Añadí el modal-footer para los botones -->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        @endforeach
    </div>

    

   

@endsection