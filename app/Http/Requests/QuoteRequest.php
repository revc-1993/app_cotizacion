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
            'type_of_transport' => ['required'],
            'cargo_type' => ['required'],
            'containerized_cargo_type' => $this->cargo_type === "Contenerizada" ? ['required'] : ['nullable'],
            'incoterm' => ['required'],
            'customer_id' => ['required'],
            'registration_date' => ['required', 'before_or_equal:' . now()->format('Y-m-d')],

            'details_charge' => ['array', 'min:1'],
            'details_service' => ['array', 'min:1'],

            'subtotal_12' => ['nullable'],
            'subtotal_0' => ['nullable'],
            'iva' => ['nullable'],
            'total' => ['nullable'],

            'international_freight_information' => ['nullable'],
            'additional_information' => ['nullable'],
            'transit_time' => ['required'],
            'quote_validity' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'type_of_transport.required' => "El campo :attribute es obligatorio",
            'cargo_type.required' => "El campo :attribute es obligatorio",
            'containerized_cargo_type.required' => "El campo :attribute es obligatorio",
            'incoterm.required' => "El campo :attribute es obligatorio",
            'registration_date.required' => "El campo :attribute es requerido",
            'registration_date.before_or_equal' => "El campo :attribute no puede ser mayor a hoy",
            'customer_id.required' => "El campo :attribute debe tener un dato válido",
            'details_charge.min' => "Debe existir al menos un detalle de carga",
            'details_service.min' => "Debe existir al menos un detalle de servicio",
            'international_freight_information.required' => "El campo :attribute es obligatorio",
            'additional_information.required' => "El campo :attribute es obligatorio",
            'transit_time.required' => "El campo :attribute es obligatorio",
            'quote_validity.required' => "El campo :attribute es obligatorio",
        ];
    }

    public function attributes()
    {
        return [
            'type_of_transport' => "Tipo de transporte",
            'cargo_type' => "Tipo de carga",
            'containerized_cargo_type' => "Tipo de carga contenerizada",
            'incoterm' => "Incoterm",
            'registration_date' => "Fecha de registro",
            'customer_id' => "Cliente",
            'international_freight_information' => "Información de flete internacional",
            'additional_information' => "Información adicional",
            'transit_time' => "Tiempo de tránsito",
            'quote_validity' => "Validez de cotización"
        ];
    }
}
