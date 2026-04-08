<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'tipo_cliente' => 'required',
            'cod_tipo_documento' => 'required',
            'dui_nit' => 'required|string|max:20|min:9',
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',

            // Opcionales por defecto
            'nombre_comercial' => 'nullable|string|max:255',
            'nrc' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'cod_actividad_economica' => 'nullable|integer',
            'fk_id_tipo_contribuyente' => 'nullable',
            'tipo_persona' => 'nullable',
            'cod_departamento' => 'nullable',
            'cod_municipio' => 'nullable',
            'descripcion_adicional' => 'nullable|string|max:500',
            'ciudad' => 'nullable|string|max:100',
            'fk_id_pais' => 'nullable|string|max:5',
            'direccion' => 'nullable|string|max:500',
        ];

        // if ($this->input('tipo_cliente') == 2) {
        //     $rules['nombre_comercial'] = 'required|string|max:255';
        //     $rules['nrc'] = 'required|string|max:50';
        //     $rules['telefono'] = 'required|string|max:20';
        //     $rules['cod_actividad_economica'] = 'required';
        //     $rules['fk_id_tipo_contribuyente'] = 'required';
        //     $rules['tipo_persona'] = 'required';
        //     $rules['departamento'] = 'required';    // ¿Seguro que no lo necesitas?
        //     $rules['municipio'] = 'required';       // ¿Seguro que no lo necesitas?
        //     $rules['ciudad'] = 'required|string|max:100';
        // }
        // if ($this->input('tipo_cliente') == 3) {
        //     $rules['telefono'] = 'required|string|max:20';
        //     $rules['fk_id_pais'] = 'required';
        //     $rules['ciudad'] = 'required|string|max:100';
        // }
        // if ($this->input('tipo_cliente') == 4) {
        //     $rules['departamento'] = 'required';
        //     $rules['municipio'] = 'required';
        //     $rules['ciudad'] = 'required|string|max:100';
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            // Obligatorios
            'tipo_cliente.required' => 'El tipo de cliente es obligatorio.',
            'cod_tipo_documento.required' => 'El tipo de documento es obligatorio.',
            'dui_nit.required' => 'El número de documento es obligatorio.',
            'nombre.required' => 'El nombre es obligatorio.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'fk_id_tipo_contribuyente.required' => 'El tipo de contribuyente es obligatorio.',
            'nombre_comercial.required' => 'El nombre comercial es obligatorio .',
            'nrc.required' => 'El NRC es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'cod_actividad_economica.required' => 'El giro es obligatorio.',
            'tipo_persona.required' => 'El tipo de persona es obligatorio.',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',


            // fk_id_tipo_contribuyente
            'fk_id_tipo_contribuyente.integer' => 'El tipo de contribuyente debe ser un valor válido.',

            // Email
            'correo.email' => 'El correo electrónico debe ser válido.',
            'correo.max' => 'El correo electrónico no debe exceder los 255 caracteres.',

            // Documento
            'dui_nit.string' => 'El documento debe ser texto.',
            'dui_nit.min' => 'El documento debe tener al menos :min caracteres.',
            'dui_nit.max' => 'El documento no debe exceder los :max caracteres.',

            // Nombre
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no debe exceder los :max caracteres.',

            // Nombre comercial
            'nombre_comercial.string' => 'El nombre comercial debe ser texto.',
            'nombre_comercial.max' => 'El nombre comercial no debe exceder los :max caracteres.',

            // Teléfono
            'telefono.string' => 'El teléfono debe ser texto.',
            'telefono.max' => 'El teléfono no debe exceder los :max caracteres.',

            // NRC
            'nrc.string' => 'El NRC debe ser texto.',
            'nrc.max' => 'El NRC no debe exceder los :max caracteres.',

            // Actividad económica
            'cod_actividad_economica.integer' => 'El giro debe ser un valor válido.',
            'cod_actividad_economica.exists' => 'El giro seleccionado no es válido.',

            // Tipo documento
            'tipo_documento.exists' => 'El tipo de documento seleccionado no es válido.',

            // Departamento
            'cod_departamento.exists' => 'El departamento seleccionado no es válido.',

            // Municipio
            'cod_municipio.exists' => 'El municipio seleccionado no es válido.',

            // Descripción
            'descripcion_adicional.string' => 'La descripción adicional debe ser texto.',
            'descripcion_adicional.max' => 'La descripción adicional no debe exceder los :max caracteres.',

            // Ciudad
            'ciudad.string' => 'La ciudad debe ser texto.',
            'ciudad.max' => 'La ciudad no debe exceder los :max caracteres.',

            // País
            'fk_id_pais.string' => 'El país debe ser texto.',
            'fk_id_pais.max' => 'El país no debe exceder los :max caracteres.',

            // Dirección
            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no debe exceder los :max caracteres.',
        ];

        
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
