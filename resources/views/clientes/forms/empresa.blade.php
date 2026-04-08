
<div id="formEmpresa" class="tipo-form d-none row g-4">

    <!---NRC / IVA---->
    <div class="col-md-4">
        <label for="nrc" class="form-label">NRC / IVA:</label>
        <input type="text" name="nrc" id="nrc" class="form-control" value="">
    </div>

    <!---Telefono ---->
    <div class="col-md-4">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" class="form-control" value="">
    </div>


    <!---Giro ---->
    <div class="col-md-4">
        <label class="form-label">Giro:</label>
        <select class="form-select" id="cod_actividad_economica" name="cod_actividad_economica">
                <option value="">Seleccione</option>
        </select>
    </div>

    <!---Tipo Contribuyente ---->
    <div class="col-md-4">
        <label class="form-label">Tipo de Contribuyente:</label>
        <select class="form-select" id="fk_id_tipo_contribuyente" name="fk_id_tipo_contribuyente">
                <option value="">Seleccione</option>
        </select>
    </div>

    <!---Tipo Persona ---->
    <div class="col-md-4">
        <label for="tipo_persona" class="form-label">Tipo de persona:</label>
        <select class="form-select" name="tipo_persona" id="tipo_persona">
            <option value="" selected disabled>Seleccione una opción</option>
            <option value="1" >Natural</option>
            <option value="2" >Juridica</option>
        </select>
    </div>

    <!---Departamentos ---->
    <div class="col-md-4">
        <label class="form-label">Departamento:</label>
        <select class="form-select departamento" id="departamento" name="departamento">
                <option value="">Seleccione</option>
        </select>
    </div>

    <!---Municipios ---->
    <div class="col-md-4">
        <label class="form-label">Municipio:</label>
        <select class="form-select municipio" id="municipio" name="municipio">
                <option value="">Seleccione</option>
        </select>
    </div>

    <!---Descripcion general---->
    <div class="col-md-4">
        <label for="descripcion_adicional" class="form-label">Descripción General:</label>
        <input type="text" name="descripcion_adicional" id="descripcion_adicional" class="form-control" value="">
    </div>

    <!---Direccion ---->
    <div class="col-md-4">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="">
    </div>

    <!---Ciudad---->
    <div class="col-md-4">
        <label for="ciudad" class="form-label">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control" value="">
    </div>
    
</div>


