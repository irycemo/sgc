<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificacionListaRequest extends FormRequest
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
            'entidad' => 'required',
            'año' => 'nullable',
            'folio' => 'nullable',
            'estado' => 'nullable',
            'localidad' => 'nullable',
            'oficina' => 'nullable',
            'tipo_predio' => 'nullable',
            'numero_registro' => 'nullable',
            'pagina' => 'required',
            'pagination' => 'required'
        ];
    }
}
