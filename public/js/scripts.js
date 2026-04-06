
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

    // Funciones para mostrar/ocultar botones
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

    // Efectos de colapsar formulario
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

        $('.tipo-form').addClass('d-none');
    });

 
    // Mostrar/ocultar campos según tipo de cliente
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
