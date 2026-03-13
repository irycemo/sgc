<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarPagoIsaiRequest extends FormRequest
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
            'localidad' => 'required|numeric|min:1',
            'oficina' => 'required|numeric|min:1',
            'tipo_predio' => 'required|numeric|min:1',
            'numero_registro' => 'required|numeric|min:1',
            'año_aviso' => 'required|numeric|min:1',
            'folio_aviso' => 'required|numeric|min:1',
            'usuario_aviso' => 'required|numeric|min:1',
            'valor_isai' => 'required|numeric'
        ];
    }
}
