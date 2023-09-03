<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'last_name' => ['required'],
            'names' => ['nullable'],
            'ruc' => ['digits:13'],
            'email' => ['email'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "El campo :attribute es obligatorio",
            'last_name.required' => "El campo :attribute es obligatorio",
            'ruc.digits' => "El campo :attribute debe tener 13 dígitos",
            'email' => "El campo :attribute debe ser un correo electrónico válido",
            'address.required' => "El campo :attribute es obligatorio",
        ];
    }

    public function attributes()
    {
        return [
            'name' => "Nombre",
            'last_name' => "Apellidos",
            'ruc' => "RUC",
            'email' => "Correo Electrónico",
            'address' => "Dirección",
        ];
    }
}
