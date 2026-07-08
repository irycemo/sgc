<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TramiteListaRequest extends FormRequest
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
            'año' => 'nullable|numeric',
            'estado' => 'nullable',
            'folio' => 'nullable',
            'usuario' => 'nullable',
            'tipo_servicio' => 'nullable',
            'servicio' => 'nullable',
            'localidad' => 'nullable',
            'oficina' => 'nullable',
            't_predio' => 'nullable',
            'registro' => 'nullable',
            'pagina' => 'required',
            'pagination' => 'required'
        ];
    }
}
