   // Variable global para la tabla
    let tablaClientes;
    //  recargar la tabla
$(document).ready(function(){
        deshabilitarCamposOcultos();
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
            ],
            order: []
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

                $('#cod_actividad_economica').html(options).trigger('change'); 
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
                    options += `<option value="${item.callingCodes[0]}">
                                    ${item.name} (+${item.callingCodes[0] ?? ''})
                                </option>`;
                });

                $('#fk_id_pais').html(options).trigger('change'); 
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

                $('#fk_id_tipo_contribuyente').html(options).trigger('change');
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

                $('.cod_departamento').html(options);
            },
            error: function(error){
                console.log(error);
            }
        });

        //Datos para el select municipios
        $('.cod_departamento').on('change', function() {

            let departamentoId = $(this).val();

            $('.cod_municipio').html('<option>Cargando...</option>');

            $.ajax({
                url: '/municipios',
                type: 'GET',
                data: { departamento_id: departamentoId },
                success: function(response){

                    let options = '<option value="">Seleccione</option>';

                    $.each(response, function(index, item){
                        options += `<option value="${item.id_municipio}">${item.municipio}</option>`;
                    });

                    $('.cod_municipio').html(options);
                }
            });

        });

        function cargarMunicipiosEdit(departamentoId, callback) {
            $.ajax({
                url: '/municipios',
                type: 'GET',
                data: { departamento_id: departamentoId },
                success: function(response) {
                    let options = '<option value="">Seleccione</option>';
                    $.each(response, function(index, item) {
                        options += `<option value="${item.id_municipio}">${item.municipio}</option>`;
                    });
                    // Afecta solo al select visible (o al que tenga clase .cod_municipio dentro del formulario visible)
                    $('.tipo-form:not(.d-none) .cod_municipio').html(options);
                    if (callback) callback();
                },
                error: function() {
                    if (callback) callback();
                }
            });
        }

        // Editar cliente
        $("body").on("click", ".edit-cliente", function(){
            let clienteId = $(this).attr("data-id");
            $.ajax({
                type: 'GET',
                url: '/clientes-data/' + clienteId,
                dataType: 'json',
                success: function(response){

                    // Asignar valores del cliente al formulario
                    $('#tipo_cliente').val(response.cliente.tipo_cliente).trigger('change');
                    $('#cod_tipo_documento').val(response.cliente.cod_tipo_documento);
                    $('#dui_nit').val(response.cliente.dui_nit);
                    $('#nombre').val(response.cliente.nombre);
                    $('#nombre_comercial').val(response.cliente.nombre_comercial);
                    $('#correo').val(response.cliente.correo);
                    $('#nrc').val(response.cliente.nrc);
                    $('.telefono').val(response.cliente.telefono);
                    $('#cod_actividad_economica').val(response.cliente.cod_actividad_economica);
                    $('#fk_id_tipo_contribuyente').val(response.cliente.fk_id_tipo_contribuyente);
                    $('#tipo_persona').val(response.cliente.tipo_persona);
                    $('.descripcion_adicional').val(response.cliente.descripcion_adicional);
                    $('.ciudad').val(response.cliente.ciudad);
                    $('#fk_id_pais').val(response.cliente.fk_id_pais);
                    $('.direccion').val(response.cliente.direccion);

                    // --- Manejo de departamento y municipio ---
                    let $depto = $('.tipo-form:not(.d-none) .cod_departamento');
                    let $municipio = $('.tipo-form:not(.d-none) .cod_municipio');

                    $depto.val(response.cliente.cod_departamento);

                    // Cargar municipios y luego asignar el valor
                    cargarMunicipiosEdit(response.cliente.cod_departamento, function() {
                        $municipio.val(response.cliente.cod_municipio);
                    });

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

        // Actualizar cliente
        $('#updateCliente').click(function(){

            let formData = {
                tipo_cliente: $('#tipo_cliente').val(),
                cod_tipo_documento: $('#cod_tipo_documento').val(),
                dui_nit: $('#dui_nit').val(),
                nombre: $('#nombre').val(),
                nombre_comercial: $('#nombre_comercial').val(),
                correo: $('#correo').val(),

                nrc: $('#nrc').val(),
                telefono: $('.tipo-form:not(.d-none) input[name="telefono"]').val(),
                cod_actividad_economica: $('#cod_actividad_economica').val(),
                fk_id_tipo_contribuyente: $('#fk_id_tipo_contribuyente').val(),
                tipo_persona: $('#tipo_persona').val(),
                cod_departamento: $('.tipo-form:not(.d-none) select[name="cod_departamento"]').val(),
                cod_municipio: $('.tipo-form:not(.d-none) select[name="cod_municipio"]').val(),
                descripcion_adicional: $('.tipo-form:not(.d-none) input[name="descripcion_adicional"]').val(),
                ciudad: $('.tipo-form:not(.d-none) input[name="ciudad"]').val(),
                fk_id_pais: $('#fk_id_pais').val(),
                direccion: $('.tipo-form:not(.d-none) input[name="direccion"]').val(),
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
                telefono: $('.tipo-form:not(.d-none) input[name="telefono"]').val(),
                cod_actividad_economica: $('#cod_actividad_economica').val(),
                fk_id_tipo_contribuyente: $('#fk_id_tipo_contribuyente').val(),
                tipo_persona: $('#tipo_persona').val(),
                cod_departamento: $('.tipo-form:not(.d-none) select[name="cod_departamento"]').val(),
                cod_municipio: $('.tipo-form:not(.d-none) select[name="cod_municipio"]').val(),
                descripcion_adicional: $('.tipo-form:not(.d-none) input[name="descripcion_adicional"]').val(),
                ciudad: $('.tipo-form:not(.d-none) input[name="ciudad"]').val(),
                fk_id_pais: $('#fk_id_pais').val(),
                direccion: $('.tipo-form:not(.d-none) input[name="direccion"]').val(),
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
                    console.log(data);

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