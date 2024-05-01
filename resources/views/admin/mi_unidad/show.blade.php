@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap4.css">
@endsection

@section('title', 'Carpetas')

@section('content')

        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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

        <hr>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="lista-documentos">
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
                            <td>Informe 2024</td>
                            <td>Muni</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-file"><i class="fas fa-edit"></i> Editar</button>                                                                    
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
  

@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap4.js"></script>

<script>
    new DataTable('#lista-documentos',{
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