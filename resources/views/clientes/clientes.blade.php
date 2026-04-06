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

<script src="{{ asset('js/scripts.js') }}"></script>

<script src="{{ asset('js/ajax.js') }}"></script>

</html>