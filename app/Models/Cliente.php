<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'venta_catalogo_cliente'; 

    protected $primaryKey = 'id_catalogo_cliente';

    protected $fillable = [
        'tipo_cliente',
        'cod_tipo_documento',
        'dui_nit',
        'nombre',
        'nombre_comercial',
        'correo',
        'nrc',
        'telefono',
        'cod_actividad_economica',
        'fk_id_tipo_contribuyente',
        'tipo_persona',
        'cod_departamento',
        'cod_municipio',
        'descripcion_adicional',
        'ciudad',
        'fk_id_pais',
        'direccion'
    ];

}