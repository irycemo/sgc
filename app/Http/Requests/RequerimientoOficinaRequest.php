<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequerimientoOficinaRequest extends FormRequest
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
            'observacion' => 'required',
            'documento' => 'nullable',
            'oficina_id' => 'required',
            'usuario' => 'required',
            'archivo_url' => 'nullable',
            'entidad_id' => 'required'
        ];
    }
}
