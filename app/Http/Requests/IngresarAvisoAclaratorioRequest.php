<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresarAvisoAclaratorioRequest extends FormRequest
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
            'predio_id' => 'required',
            'tramite_aviso' => 'required',
            'certificacion_id' => 'required',
            'avaluo_spe' => 'required',
            'aviso_stl' => 'required',
            'entidad_stl' => 'required',
            'entidad_nombre' => 'required',
        ];
    }
}
