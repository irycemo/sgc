<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrasladoRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'predio' => 'required',
            'tramite_aviso' => 'required',
            'tramite_certificado' => 'required',
            'aviso_id' => 'required',
            'avaluo_id' => 'required',
            'entidad_nombre' => 'required',
            'entidad_id' => 'required'
        ];
    }
}
