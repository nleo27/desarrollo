@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
@endsection

@section('title', 'Carpetas')

@section('content')
    
<style>
    .info-box-link {
    display: inline-block;
}

.info-box-link .info-box {
    border: 1px solid #ddd; /* Restaurar borde */
    border-radius: 5px; /* Ajustar al mismo borde del info-box */
}

.info-box-link .info-box-icon {
    display: block; /* Forzar icono a bloque para controlar tamaño */
}

.info-box-link .info-box-content {
    padding: 10px; /* Ajustar el relleno */
}

.info-box-link .dropdown {
    position: relative; /* Asegurar que el menú desplegable aparezca correctamente */
}
</style>

    <div class="content-header">     
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mi Unidad</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="card-tools">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-registrar-archivador"><i class="fas fa-solid fa-folder-plus"></i> Registrar Archivador</button>
                        </div>
                    </ol>
                </div>
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
                    <form action="{{url('/admin/mi_unidad')}}" method="POST">
                        @csrf
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
    <h5>Mis Carpetas</h5>
    <hr>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box" onclick="location.href='#';" style="cursor: pointer;">
                <span class="info-box-icon bg-info"><i class="fas fa-folder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-number">OFICIOS</span>
                </div>
                <!-- Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Editar</a>
                        <a class="dropdown-item" href="#">Eliminar</a>
                    </div>
                </div>
                <!-- /Dropdown -->
            </div>
                      
          
            
        </div>
    </div>

@endsection