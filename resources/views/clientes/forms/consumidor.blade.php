<div id="formConsumidor" class="tipo-form d-none row g-4">

    <!---Direccion ---->
    <div class="col-md-4">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion' ?? '')}}">
        @error('direccion')
        <small class="text-danger">{{'*'.$message}}</small>
        @enderror
    </div>
</div>