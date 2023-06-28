<?php

namespace Database\Factories;

use App\Http\Constantes\Constantes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => $this->faker->randomElement(['FISICA','MORAL']),
            'nombre' => $this->faker->name(),
            'ap_paterno' => $this->faker->word(),
            'ap_materno' => $this->faker->word(),
            'curp' => Str::random(18),
            'rfc' => Str::random(10),
            'razon_social' => $this->faker->word(),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('1950-01-01', '2000-12-31'),
            'nacionalidad' => 'Mexicana',
            'estado_civil' => $this->faker->randomElement(['soltero', 'casado', 'viudo', 'divorciado']),
            'calle' => $this->faker->word(),
            'numero_exterior' => $this->faker->numberBetween(1,1000),
            'numero_interior' => $this->faker->numberBetween(1,1000),
            'colonia' => $this->faker->word(),
            'municipio' => $this->faker->word(),
        ];
    }
}
