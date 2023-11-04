<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
            'mail_mailer' => ['required'],
            'mail_host' => ['required'],
            'email' => ['required'],
            'mail_password' => ['required'],
            'mail_port' => ['numeric'],
            'mail_from_address' => ['nullable'],
            'mail_from_name' => ['required'],

        ];
    }

    public function messages()
    {
        return [
            'mail_mailer.required' => "El campo :attribute es obligatorio",
            'mail_host.required' => "El campo :attribute es obligatorio",
            'email' => "El campo :attribute es obligatorio",
            'mail_password.required' => "El campo :attribute es obligatorio",
            'mail_port.numeric' => "El campo :attribute debe ser numérico",
            'mail_from_address.email' => "El campo :attribute debe ser un correo electrónico válido",
            'mail_from_name.required' => "El campo :attribute es obligatorio",
        ];
    }

    public function attributes()
    {
        return [
            'mail_mailer' => "Protocolo",
            'mail_host' => "Host",
            'email' => "Correo Electrónico",
            'mail_password' => "Contraseña",
            'mail_port' => "Puerto",
            'mail_from_address' => "Email Remitente",
            'mail_from_name' => "Nombre Remitente",
        ];
    }
}
