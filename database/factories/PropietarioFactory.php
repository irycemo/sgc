<?php

namespace Database\Factories;

use App\Http\Constantes\Constantes;
use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Propietario>
 */
class PropietarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $personas = Persona::pluck('id');

        return [
            'persona_id' => $this->faker->randomElement($personas),
            'tipo' => $this->faker->randomElement(Constantes::TIPO_PROPIETARIO),
            'porcentaje' => 50
        ];
    }
}
