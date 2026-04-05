<div id="formExtranjero" class="tipo-form d-none row g-4">

    <!---Pais ---->
    <div class="col-md-4">
        <label class="form-label">País:</label>
        <select class="form-select" id="pais" name="pais">
                <option value="">Seleccione</option>
        </select>
    </div>

    <!---Telefono ---->
    <div class="col-md-4">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" class="form-control" value="{{old('telefono' ?? '')}}">
        @error('telefono')
        <small class="text-danger">{{'*'.$message}}</small>
        @enderror
    </div>

        <!---Descripcion general---->
    <div class="col-md-4">
        <label for="descripcion_adicional" class="form-label">Descripción General:</label>
        <input type="text" name="descripcion_adicional" id="descripcion_adicional" class="form-control" value="{{old('descripcion_adicional' ?? '')}}">
        @error('descripcion_adicional')
        <small class="text-danger">{{'*'.$message}}</small>
        @enderror
    </div>

    <!---Direccion ---->
    <div class="col-md-4">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion' ?? '')}}">
        @error('direccion')
        <small class="text-danger">{{'*'.$message}}</small>
        @enderror
    </div>

    <!---Ciudad---->
    <div class="col-md-4">
        <label for="ciudad" class="form-label">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{old('ciudad' ?? '')}}">
        @error('ciudad')
        <small class="text-danger">{{'*'.$message}}</small>
        @enderror
    </div>


</div>