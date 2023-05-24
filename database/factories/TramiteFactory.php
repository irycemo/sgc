<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tramite>
 */
class TramiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $servicio = Servicio::inRandomOrder()->first();

        return [
            'estado' => $this->faker->randomElement(['nuevo', 'pagado', 'activo', 'concluido']),
            'tipo_tramite' => $this->faker->randomElement(['normal', 'complemento', 'exento', 'porcentaje', 'parcial']),
            'tipo_servicio' => $this->faker->randomElement(['ordinario', 'urgente', 'extra urgente']),
            'cantidad' => $this->faker->numberBetween(1,10),
            'solicitante' => $this->faker->name(),
            'observaciones' => $this->faker->text(),
            'servicio_id' => $servicio->id,
            'monto' => $servicio->ordinario,
            'folio' => $this->faker->unique()->randomNumber,
            'fecha_entrega' => $this->faker->dateTimeBetween(now()->subMonths($this->faker->numberBetween(1,10)), now()->addMonths($this->faker->numberBetween(1,5))),
            'fecha_pago' => now()->subMonths($this->faker->numberBetween(1,10)),
            'folio_pago' => 8694618464,
            'orden_de_pago' => 3213216546545,
            'linea_de_captura' => 321321654654569153,
        ];
    }
}
