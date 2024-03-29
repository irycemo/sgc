<?php

namespace Database\Factories;

use App\Models\Oficina;
use Illuminate\Support\Arr;
use App\Http\Constantes\Constantes;
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
        $oficina = Oficina::inRandomOrder()->first();

        $sectores = json_decode($oficina->sectores, true);

        return [
            'estado' => 16,
            'region_catastral' => $this->faker->numberBetween(1,100),
            'municipio' => $oficina->municipio,
            'zona_catastral' => $oficina->localidad,
            'tipo_vialidad' => $this->faker->randomElement(Constantes::TIPO_VIALIDADES),
            'tipo_asentamiento' => $this->faker->randomElement(Constantes::TIPO_ASENTAMIENTO),
            'nombre_vialidad' => $this->faker->sentence(),
            'nombre_edificio' => $this->faker->sentence(),
            'nombre_predio' => $this->faker->sentence(),
            'clave_edificio' => $this->faker->sentence(),
            'departamento_edificio' => $this->faker->sentence(),
            'nombre_asentamiento' => $this->faker->sentence(),
            'numero_exterior' => $this->faker->numberBetween(1,100),
            'numero_exterior_2' => $this->faker->numberBetween(1,100),
            'numero_adicional' => $this->faker->numberBetween(1,100),
            'numero_adicional_2' => $this->faker->numberBetween(1,100),
            'numero_interior' => $this->faker->numberBetween(1,100),
            'lote_fraccionador' => $this->faker->numberBetween(1,100),
            'manzana_fraccionador' => $this->faker->numberBetween(1,100),
            'etapa_fraccionador' => $this->faker->numberBetween(1,100),
            'codigo_postal' => $this->faker->numberBetween(1,100),
            'localidad' => $oficina->localidad,
            'sector' => Arr::random($sectores),
            'manzana' => $this->faker->numberBetween(1,100),
            'predio' => $this->faker->numberBetween(1,100),
            'edificio' => $this->faker->numberBetween(1,100),
            'departamento' => $this->faker->numberBetween(1,100),
            'oficina' => $oficina->oficina,
            'tipo_predio' => $this->faker->numberBetween(1,2),
            'numero_registro' => $this->faker->numberBetween(1,100000),
            'superficie_terreno' => $this->faker->numberBetween(1,100),
            'superficie_construccion' => $this->faker->numberBetween(1,100),
            'superficie_notarial' => $this->faker->numberBetween(1,100),
            'valor_catastral' => $this->faker->numberBetween(1,100),
            'valor_total_terreno' => $this->faker->numberBetween(1,100),
            'valor_total_construccion' => $this->faker->numberBetween(1,100),
            'documento_numero' => $this->faker->numberBetween(1,100),
            'superficie_notarial' => $this->faker->numberBetween(1,100),
            'superficie_notarial' => $this->faker->numberBetween(1,100),
        ];
    }
}
