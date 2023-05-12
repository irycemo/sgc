<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Predio>
 */
class PredioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'estado' => 16,
            'region_catastral' => $this->faker->numberBetween(1,100),
            'municipio' => $this->faker->numberBetween(1,100),
            'zona_catastral' => $this->faker->numberBetween(1,100),
            'tipo_vialidad' => $this->faker->sentence(),
            'nombre_vialidad' => $this->faker->sentence(),
            'numero_exterior' => $this->faker->numberBetween(1,100),
            'localidad' => $this->faker->numberBetween(1,100),
            'sector' => $this->faker->numberBetween(1,100),
            'manzana' => $this->faker->numberBetween(1,100),
            'predio' => $this->faker->numberBetween(1,100),
            'edificio' => $this->faker->numberBetween(1,100),
            'departamento' => $this->faker->numberBetween(1,100),
            'oficina' => $this->faker->numberBetween(1,100),
            'tipo_predio' => $this->faker->numberBetween(1,2),
            'numero_registro' => $this->faker->numberBetween(1,100),
            'superficie_terreno' => $this->faker->numberBetween(1,100),
            'superficie_construccion' => $this->faker->numberBetween(1,100),
            'superficie_notarial' => $this->faker->numberBetween(1,100),
            'valor_catastral' => $this->faker->numberBetween(1,100),
            'valor_total_terreno' => $this->faker->numberBetween(1,100),
            'valor_construccion' => $this->faker->numberBetween(1,100),
            'titulo_propiedad' => $this->faker->numberBetween(1,100),
            'superficie_notarial' => $this->faker->numberBetween(1,100),
            'superficie_notarial' => $this->faker->numberBetween(1,100),
        ];
    }
}
