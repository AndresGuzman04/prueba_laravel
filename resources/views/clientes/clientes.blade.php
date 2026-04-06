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

    <!-- SweetAlert2 CSS y JS desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                
                <form id="clienteForm">
                    @csrf
                    <div class="card-body">
                        <div class="row g-4">

                            
                            <!----Tipo de cliente----->
                            <div class="col-md-4">
                                <label for="tipo_cliente" class="form-label">Tipo de cliente:</label>
                                <select class="form-select" name="tipo_cliente" id="tipo_cliente">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1" {{ old('tipo_cliente') == '1' ? 'selected' : '' }}>Consumidor Final</option>
                                    <option value="2" {{ old('tipo_cliente') == '2' ? 'selected' : '' }}>Empresa</option>
                                    <option value="3" {{ old('tipo_cliente') == '3' ? 'selected' : '' }}>Extranjero</option>
                                    <option value="4" {{ old('tipo_cliente') == '4' ? 'selected' : '' }}>Proveedor</option>
                                </select>
                            </div>

                            <!----Tipo de documento----->
                            <div class="col-md-4">
                                <label class="form-label">Tipo de documento:</label>
                                <select class="form-select" id="cod_tipo_documento">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <!-----documento---->
                            <div class="col-sm-4 mb-2">
                                <label for="dui_nit" class="form-label">Nº Documento:</label>
                                <input type="text" name="dui_nit" id="dui_nit" class="form-control">
                            </div>

                            <!---Razon Social/nombre---->
                            <div class="col-md-4">
                                <label for="nombre" class="form-label">Razón Social / Nombre del cliente:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre' ?? '')}}">
                            </div>

                            <!---Nombre Comercial---->
                            <div class="col-md-4">
                                <label for="nombre_comercial" class="form-label">Nombre Comercial:</label>
                                <input type="text" name="nombre_comercial" id="nombre_comercial" class="form-control" value="{{old('nombre_comercial' ?? '')}}">
                            </div>

                            <!---Correo ---->
                            <div class="col-md-4">
                                <label for="correo" class="form-label">Correo:</label>
                                <input type="email" name="correo" id="correo" class="form-control" value="{{old('correo' ?? '')}}">
                            </div>

                            @include('clientes.forms.consumidor')
                            @include('clientes.forms.empresa')
                            @include('clientes.forms.extranjero')
                            @include('clientes.forms.proveedor')

                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <button type="button" id="saveCliente" class="btn btn-primary">Guardar</button>
                        <button type="button" id="updateCliente" class="btn btn-warning">Actualizar</button>
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

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>

    // Configuración de Toast 
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,              // 2 segundos (ajústalo)
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    let clienteId = null;
    // Referencias a los botones
    const $btnSave = $('#saveCliente');
    const $btnUpdate = $('#updateCliente');

    // ========== FUNCIONES PARA CAMBIAR VISIBILIDAD DE BOTONES ==========
    function mostrarModoCreacion() {
        $btnSave.show();
        $btnUpdate.hide();
        clienteId = null;
    }

    function mostrarModoEdicion(id) {
        clienteId = id;
        $btnSave.hide();
        $btnUpdate.show();
    }

    
    const collapseElement = document.getElementById('formCliente');
    const icon = document.getElementById('iconToggle');

    collapseElement.addEventListener('show.bs.collapse', function () {
        icon.classList.add('rotate');
        icon.classList.remove('fa-plus');
        icon.classList.add('fa-xmark');
        mostrarModoCreacion();
    });

    collapseElement.addEventListener('hide.bs.collapse', function () {
        icon.classList.remove('rotate');
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-plus');
        $('#clienteForm')[0].reset();

        $('select').val('');
        mostrarModoCreacion();
        //eliminar span dentro del formulario
        $('#clienteForm span').remove();
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
    // Variable global para la tabla
    let tablaClientes;
    //  recargar la tabla
    $(document).ready(function(){

        tablaClientes = $('#tablaClientes').DataTable({
        ajax: {
            url: '/clientes-data',
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
                        <button data-id="${row.id_catalogo_cliente}" class="btn btn-info btn-sm edit-cliente"><i class="fa-solid fa-pen"></i></button>
                        <button data-id="${row.id_catalogo_cliente}" class="btn btn-danger btn-sm delete-cliente"><i class="fa-solid fa-trash"></i></button>
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

            $('#cod_tipo_documento').html(options);
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


        $("body").on("click", ".edit-cliente", function(){
            let clienteId = $(this).attr("data-id");
            $.ajax({
                type: 'GET',
                url: '/clientes-data/' + clienteId,
                dataType: 'json',
                success: function(response){
                    console.log(response);

                    // Asignar valores del cliente al formulario
                    $('#tipo_cliente').val(response.cliente.tipo_cliente).trigger('change');
                    $('#cod_tipo_documento').val(response.cliente.cod_tipo_documento);
                    $('#dui_nit').val(response.cliente.dui_nit);
                    $('#nombre').val(response.cliente.nombre);
                    $('#nombre_comercial').val(response.cliente.nombre_comercial);
                    $('#correo').val(response.cliente.correo);
                    $('#nrc').val(response.cliente.nrc);
                    $('#telefono').val(response.cliente.telefono);
                    $('#giro').val(response.cliente.cod_actividad_economica);
                    $('#tipo_contribuyente').val(response.cliente.fk_id_tipo_contribuyente);
                    $('#tipo_persona').val(response.cliente.tipo_persona);
                    $('#departamento').val(response.cliente.cod_departamento);
                    $('#municipio').val(response.cliente.cod_municipio);
                    $('#descripcion_adicional').val(response.cliente.descripcion_adicional);
                    $('#ciudad').val(response.cliente.ciudad);
                    $('#pais').val(response.cliente.fk_id_pais);
                    $('#direccion').val(response.cliente.direccion);

                    let collapseElement = document.getElementById('formCliente');

                    // 🔥 FORZAR cierre
                    let bsCollapse = new bootstrap.Collapse(collapseElement, {
                        toggle: false
                    });

                    bsCollapse.show();

                    mostrarModoEdicion(clienteId);

                },
                error: function(xhr){
                    Toast.fire('Error', 'No se pudo cargar el cliente para editar', 'error');
                }
            });
        });

        $('#updateCliente').click(function(){

            console.log('Actualizando cliente con ID:', clienteId);

            let formData = {
                tipo_cliente: $('#tipo_cliente').val(),
                cod_tipo_documento: $('#cod_tipo_documento').val(),
                dui_nit: $('#dui_nit').val(),
                nombre: $('#nombre').val(),
                nombre_comercial: $('#nombre_comercial').val(),
                correo: $('#correo').val(),

                nrc: $('#nrc').val(),
                telefono: $('#telefono').val(),
                cod_actividad_economica: $('#giro').val(),
                fk_id_tipo_contribuyente: $('#tipo_contribuyente').val(),
                tipo_persona: $('#tipo_persona').val(),
                cod_departamento: $('#departamento').val(),
                cod_municipio: $('#municipio').val(),
                descripcion_adicional: $('#descripcion_adicional').val(),
                ciudad: $('#ciudad').val(),
                fk_id_pais: $('#pais').val(),
                direccion: $('#direccion').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $(".error-message").remove();

            $.ajax({
                url: '/clientes-data/' + clienteId,
                type: 'PUT',
                data: formData,
                dataType: 'json',
                success: function(response){
                    if(response.errors){
                        $.each(response.errors, function(key, value){
                            $("#"+key).after('<span class="text-danger error-message">'+value+'</span>');
                        });
                    } else {
                       
                    // Éxito
                    $('#clienteForm')[0].reset();

                    $('select').val('');

                    let collapseElement = document.getElementById('formCliente');

                    // 🔥 FORZAR cierre
                    let bsCollapse = new bootstrap.Collapse(collapseElement, {
                        toggle: false
                    });

                    bsCollapse.hide();

                    tablaClientes.ajax.reload();

                    Toast.fire('¡Actualizado!', 'Los datos del cliente se actualizaron.', 'success');
                    }

                    
                },
                error: function(xhr){
                    Toast.fire('Error', 'No se pudo actualizar el cliente.', 'error');
                }
            });
        });

        //Guardar cliente
        $('#saveCliente').click(function(){

            let formData = {
                tipo_cliente: $('#tipo_cliente').val(),
                cod_tipo_documento: $('#cod_tipo_documento').val(),
                dui_nit: $('#dui_nit').val(),
                nombre: $('#nombre').val(),
                nombre_comercial: $('#nombre_comercial').val(),
                correo: $('#correo').val(),

                nrc: $('#nrc').val(),
                telefono: $('#telefono').val(),
                cod_actividad_economica: $('#giro').val(),
                fk_id_tipo_contribuyente: $('#tipo_contribuyente').val(),
                tipo_persona: $('#tipo_persona').val(),
                cod_departamento: $('#departamento').val(),
                cod_municipio: $('#municipio').val(),
                descripcion_adicional: $('#descripcion_adicional').val(),
                ciudad: $('#ciudad').val(),
                fk_id_pais: $('#pais').val(),
                direccion: $('#direccion').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $(".error-message").remove();

            $.ajax({
                url: '/clientes-data',
                type: 'POST',
                data: formData,
                dataType: 'json',

                success: function(response){

                    // Éxito
                    $('#clienteForm')[0].reset();

                    $('select').val('');

                    let collapseElement = document.getElementById('formCliente');

                    // 🔥 FORZAR cierre
                    let bsCollapse = new bootstrap.Collapse(collapseElement, {
                        toggle: false
                    });

                    bsCollapse.hide();

                    tablaClientes.ajax.reload();

                    Toast.fire('¡Creado!', 'El cliente se ha guardado correctamente.', 'success');

                },

                error: function(xhr){

                    if(xhr.status === 422){

                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value){
                            $("#" + key).after(
                                '<span class="text-danger error-message">' + value[0] + '</span>'
                            );
                        });

                    } else {
                    Toast.fire('Error', 'Hubo un problema al guardar el cliente.', 'error');
                    }
                }
            });
        });

        // Eliminar cliente
        $("body").on("click", ".delete-cliente", function(){
            let id_catalogo_cliente = $(this).attr("data-id");
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí va tu petición AJAX
                    $.ajax({
                        type: 'DELETE',
                        url: '/clientes-data/' + id_catalogo_cliente,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response){
                            tablaClientes.ajax.reload();
                            Toast.fire('¡Eliminado!', 'El cliente ha sido eliminado.', 'success');
                        },
                        error: function(xhr){
                            Toast.fire('Error', 'No se pudo eliminar el cliente.', 'error');
                        }
                    });
                }
            });
        });


    });
</script>

</html>