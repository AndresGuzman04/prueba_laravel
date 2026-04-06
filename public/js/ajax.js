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
                    options += `<option value="${item.alpha2Code}">
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

                $('.departamento').html(options);
            },
            error: function(error){
                console.log(error);
            }
        });

        //Datos para el select municipios
        $('.departamento').on('change', function() {

            let departamentoId = $(this).val();

            $('.municipio').html('<option>Cargando...</option>');

            $.ajax({
                url: '/municipios',
                type: 'GET',
                data: { departamento_id: departamentoId },
                success: function(response){

                    let options = '<option value="">Seleccione</option>';

                    $.each(response, function(index, item){
                        options += `<option value="${item.id_municipio}">${item.municipio}</option>`;
                    });

                    $('.municipio').html(options);
                }
            });

        });

        // Editar cliente
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

        // Actualizar cliente
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
                fk_id_tipo_contribuyente: $('#fk_id_tipo_contribuyente').val(),
                tipo_persona: $('#tipo_persona').val(),
                cod_departamento: $('#departamento').val(),
                cod_municipio: $('#municipio').val(),
                descripcion_adicional: $('#descripcion_adicional').val(),
                ciudad: $('#ciudad').val(),
                fk_id_pais: $('#fk_id_pais').val(),
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