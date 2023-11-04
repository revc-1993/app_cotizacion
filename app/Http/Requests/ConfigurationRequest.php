<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
        // dd($this->logo);
        return [
            'company_name' => ['required'],
            'ruc' => ['digits:13'],
            'contact_number' => ['digits:10'],
            'email' => ['required'],
            'address' => ['required'],
            'regime_category' => ['required'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => "El campo :attribute es obligatorio",
            'ruc.digits' => "El campo :attribute debe tener 13 dígitos",
            'contact_number.digits' => "El campo :attribute debe tener 10 dígitos",
            'email' => "El campo :attribute es obligatorio",
            'regime_category' => "El campo :attribute es obligatorio",
            'address.required' => "El campo :attribute es obligatorio",
            'logo.image' => "El campo :attribute debe ser una imagen",
            'logo.mimes' => "El campo :attribute debe ser una imagen en formato JPEG, PNG, JPG o GIF",
            'logo.max' => "El campo :attribute no debe superar los 2MB",
        ];
    }

    public function attributes()
    {
        return [
            'company_name' => "Nombre de empresa",
            'ruc' => "RUC",
            'contact_number' => "Número de contacto",
            'email' => "Correo Electrónico",
            'address' => "Dirección",
            'regime_category' => "Categoría régimen",
            'logo' => "Logo de la empresa",
        ];
    }
}
