<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>



    <style>
        #iconToggle {
            transition: transform 0.3s ease;
        }

        .rotate {
            transform: rotate(180deg);
        }
    </style>
    
</head>
<body>

<div class="container">
    <div class="card mt-5">
        <div class="card-header p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Clientes</h5>
            
            <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formCliente">
                <i id="iconToggle" class="fa-solid fa-plus"></i>
            </button>
        </div>


        <div class="collapse" id="formCliente">
            <div class="card card-body">
                
                <form action="" method="post">
                @csrf
                <div class="card-body">
                    <div class="row g-4">

                        
                        <!----Tipo de cliente----->
                        <div class="col-md-12">
                            <label for="tipo_cliente" class="form-label">Tipo de cliente:</label>
                            <select class="form-select" name="tipo_cliente" id="tipo_cliente">
                                <option value="" selected disabled>Seleccione una opción</option>
                                <option value="1" {{ old('tipo_cliente') == '1' ? 'selected' : '' }}>Consumidor Final</option>
                                <option value="2" {{ old('tipo_cliente') == '2' ? 'selected' : '' }}>Empresa</option>
                                <option value="3" {{ old('tipo_cliente') == '3' ? 'selected' : '' }}>Extranjero</option>
                                <option value="4" {{ old('tipo_cliente') == '4' ? 'selected' : '' }}>Proveedor</option>
                            </select>
                            @error('tipo_cliente')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <!----Tipo de documento----->
                        <div class="col-md-4">
                            <label class="form-label">Tipo de documento:</label>
                            <select class="form-select" id="tipo_documento">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <!-----documento---->
                        <div class="col-sm-4 mb-2">
                            <label for="documento" class="form-label">Nº Documento:</label>
                            <input type="text" name="documento" id="documento" class="form-control">
                        </div>

                        <!---Razon Social/nombre---->
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Razón Social / Nombre del cliente:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre' ?? '')}}">
                            @error('nombre')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <!---Nombre Comercial---->
                        <div class="col-md-4">
                            <label for="nombre_comercial" class="form-label">Nombre Comercial:</label>
                            <input type="text" name="nombre_comercial" id="nombre_comercial" class="form-control" value="{{old('nombre_comercial' ?? '')}}">
                            @error('nombre_comercial')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <!---Correo ---->
                        <div class="col-md-4">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" name="correo" id="correo" class="form-control" value="{{old('correo' ?? '')}}">
                            @error('correo')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        @include('clientes.forms.consumidor')
                        @include('clientes.forms.empresa')
                        @include('clientes.forms.extranjero')
                        @include('clientes.forms.proveedor')

                    
                        
                    </div>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaClientes" class="table">
                    <thead>
                        <tr>
                            <th>Razon Social</th>
                            <th>Nombre Comercial</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Nº Documento</th>
                            <th>NRC</th>
                            <th>Correo</th>
                            <th width="5rem">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="clienteTableList"></tbody>
                </table>
            </div>

        </div>

        <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTaskModalLabel">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createTaskForm">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveTaskBtn" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <input type="hidden" id="task-id-edit"> 
                    <div class="mb-3">
                        <label for="title-edit" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title-edit">
                    </div>
                    <div class="mb-3">
                        <label for="description-edit" class="form-label">Description</label>
                        <textarea class="form-control" id="description-edit" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="editTaskBtn" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    const collapseElement = document.getElementById('formCliente');
    const icon = document.getElementById('iconToggle');

    collapseElement.addEventListener('show.bs.collapse', function () {
        icon.classList.add('rotate');
        icon.classList.remove('fa-plus');
        icon.classList.add('fa-xmark');
    });

    collapseElement.addEventListener('hide.bs.collapse', function () {
        icon.classList.remove('rotate');
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-plus');
    });


    $('#tipo_cliente').on('change', function () {

        let tipo = $(this).val();

        // ocultar todos
        $('.tipo-form').addClass('d-none');

        // mostrar según selección
        if (tipo == '1') {
            $('#formConsumidor').removeClass('d-none');
        } 
        else if (tipo == '2') {
            $('#formEmpresa').removeClass('d-none');
        } 
        else if (tipo == '3') {
            $('#formExtranjero').removeClass('d-none');
        } 
        else if (tipo == '4') {
            $('#formProveedor').removeClass('d-none');
        }
    });

    $('#giro').select2({
        placeholder: 'Seleccione un giro',
        allowClear: true,
        width: '100%'
    });

    $('#pais').select2({
        placeholder: 'Seleccione un país',
        allowClear: true
    });

</script>


<script>
    $(document).ready(function(){

        $('#tablaClientes').DataTable({
        ajax: {
            url: '/clientes',
            dataSrc: 'clientes'
        },
        columns: [
            { data: 'nombre' },
            { data: 'nombre_comercial' },
            { data: 'telefono' },
            { data: 'direccion' },
            { data: 'dui_nit' },
            { data: 'nrc' },
            { data: 'correo' },
            {
                data: null,
                render: function(data, type, row){
                    return `
                        <button data-id="${row.id_catalogo_cliente}" class="btn btn-info btn-sm"><i class="fa-solid fa-pen"></i></button>
                        <button data-id="${row.id_catalogo_cliente}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                    `;
                }
            }
        ]
    });

    //Obtener tipos de documento para el select
    $.ajax({
        url: '/tipos-documento',
        type: 'GET',
        dataType: 'json',
        success: function(response){

            let options = '<option value="">Seleccione</option>';

            $.each(response.documentos, function(index, item){
                options += `<option value="${item.id_tipo_documento}">${item.tipo_documento}</option>`;
            });

            $('#tipo_documento').html(options);
        },
        error: function(error){
            console.log(error);
        }
    });

    //Datos para el select de giros
    $.ajax({
        url: '/giros',
        type: 'GET',
        dataType: 'json',
        success: function(response){

            let options = '<option value="">Seleccione</option>';

            $.each(response.giros, function(index, item){
                options += `<option value="${item.id_actividad_economica}">${item.actividad_economica}</option>`;
            });

            $('#giro').html(options).trigger('change'); 
        },
        error: function(error){
            console.log(error);
        }
    });

    //Datos para el select de paises
    $.ajax({
        url: '/paises',
        type: 'GET',
        dataType: 'json',
        success: function(response){

            console.log(response);

            let options = '<option value="">Seleccione</option>';

            $.each(response, function(index, item){
                options += `<option value="${item.alpha2Code}">
                                ${item.name} (+${item.callingCodes[0] ?? ''})
                            </option>`;
            });

            $('#pais').html(options).trigger('change'); 
        },
        error: function(error){
            console.log(error);
        }
    });

    //Datos para el select de tipo de contribuyente
    $.ajax({
        url: '/tipos-contribuyente',
        type: 'GET',
        dataType: 'json',
        success: function(response){

            let options = '<option value="">Seleccione</option>';

            $.each(response.tipo_contribuyentes, function(index, item){
                options += `<option value="${item.id_tipo_contribuyente}">${item.tipo_contribuyente}</option>`;
            });

            $('#tipo_contribuyente').html(options).trigger('change');
        },
        error: function(error){
            console.log(error);
        }
    });

    //Datos para el select de departamentos
    $.ajax({
        url: '/departamentos',
        type: 'GET',
        dataType: 'json',
        success: function(response){

            let options = '<option value="">Seleccione</option>';

            $.each(response.departamentos, function(index, item){
                options += `<option value="${item.id_departamento}">${item.departamento}</option>`;
            });

            $('#departamento').html(options);
        },
        error: function(error){
            console.log(error);
        }
    });

    //Datos para el select municipios
    $('#departamento').on('change', function() {

        let departamentoId = $(this).val();

        $('#municipio').html('<option>Cargando...</option>');

        $.ajax({
            url: '/municipios',
            type: 'GET',
            data: { departamento_id: departamentoId },
            success: function(response){

                let options = '<option value="">Seleccione</option>';

                $.each(response, function(index, item){
                    options += `<option value="${item.id_municipio}">${item.municipio}</option>`;
                });

                $('#municipio').html(options);
            }
        });

    });


        $("body").on("click", ".edit-task", function(){
            let taskId = $(this).attr("data-id");
            $.ajax({
                type: 'GET',
                url: '/tasks/' + taskId,
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    $('#title-edit').val(response.task.title);
                    $('#description-edit').val(response.task.description);
                    $('#task-id-edit').val(response.task.id);
                    $('#editTaskModal').modal('show');

                },
                error: function(error){
                    console.log(error);
                }
            });
        });

        $("body").on("click", ".delete-task", function(){
            let taskId = $(this).attr("data-id");
            if(confirm("Are you sure you want to delete this task?")){
                $.ajax({
                    type: 'DELETE',
                    url: '/tasks/' + taskId,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response){
                        fecthTasks();
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });

        $('#editTaskBtn').click(function(){

            let formData = {
                title: $('#title-edit').val(),
                description: $('#description-edit').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $(".error-message").remove();

            $.ajax({
                url: '/tasks/' + $('#task-id-edit').val(),
                type: 'PUT',
                data: formData,
                dataType: 'json',
                success: function(response){
                    if(response.errors){
                        $.each(response.errors, function(key, value){
                            $("#"+key+"-edit").after('<span class="text-danger error-message">'+value+'</span>');
                        });
                    } else {
                        $('#editTaskModal').modal('hide');
                        fecthTasks();
                        $('#title').val('');
                        $('#description').val('');
                    }
                    
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#saveTaskBtn').click(function(){

            let formData = {
                title: $('#title').val(),
                description: $('#description').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $(".error-message").remove();

            $.ajax({
                url: '/tasks',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response){
                    if(response.errors){
                        $.each(response.errors, function(key, value){
                            $("#"+key).after('<span class="text-danger error-message">'+value+'</span>');
                        });
                    } else {
                        $('#createTaskModal').modal('hide');
                        fecthTasks();
                        $('#title').val('');
                        $('#description').val('');
                    }
                    
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

</html>