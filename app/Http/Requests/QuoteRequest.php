<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'type_of_transport' => ['required'],
            'product' => ['required'],
            'cargo_type' => ['required'],
            'weight' => $this->cargo_type === "Suelta" ? ['numeric', 'min:1'] : ['nullable'],
            'unit_of_weight_measurement' => $this->weight > 0 ? ['required'] : ['nullable'],
            'length' => $this->cargo_type === "Suelta" ? ['numeric', 'min:1'] : ['nullable'],
            'unit_of_length_measurement' => $this->length > 0 ? ['required'] : ['nullable'],
            'containerized_cargo_type' => $this->cargo_type === "Contenerizada" ? ['required'] : ['nullable'],
            'number_of_containers' => ['required', 'min:1'],
            'single_cargo_name' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "El campo :attribute es obligatorio",
            'type_of_transport.required' => "El campo :attribute es obligatorio",
            'product.required' => "El campo :attribute es obligatorio",
            'cargo_type.required' => "El campo :attribute es obligatorio",
            'weight.numeric' => "El campo :attribute debe ser numérico",
            'weight.min' => "El campo :attribute debe ser mayor que 0",
            'unit_of_weight_measurement.required' => "El campo :attribute es obligatorio",
            'length.numeric' => "El campo :attribute debe ser numérico",
            'length.min' => "El campo :attribute debe ser mayor que 0",
            'unit_of_length_measurement.required' => "El campo :attribute es obligatorio",
            'containerized_cargo_type.required' => "El campo :attribute es obligatorio",
            'number_of_containers.required' => "El campo :attribute es obligatorio",
            'number_of_containers.min' => "El campo :attribute debe ser mayor que 0",
            'single_cargo_name.required' => "El campo :attribute es obligatorio",
        ];
    }

    public function attributes()
    {
        return [
            'name' => "Nombre",
            'type_of_transport' => "Tipo de transporte",
            'product' => "Producto",
            'cargo_type' => "Tipo de carga",
            'weight' => "Peso",
            'unit_of_weight_measurement' => "Unidad de medida de peso",
            'length' => "Longitud",
            'unit_of_length_measurement' => "Unidad de medida de longitud",
            'containerized_cargo_type' => "Tipo de carga contenerizada",
            'number_of_containers' => "Nro. de carga",
            'single_cargo_name' => "Nombre de carga",
        ];
    }
}
