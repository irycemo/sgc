<?php

namespace Database\Seeders;

use App\Models\Oficina;
use App\Models\AsignarCuenta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AsignarCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oficinas = Oficina::all();

        foreach ($oficinas as $oficina) {

            AsignarCuenta::create([
                'localidad' => $oficina->localidad,
                'oficina' => $oficina->oficina,
                'tipo_predio' => 1,
                'numero_registro' => 1,
                'estatus' => 1,
                'observaciones' => 'Origen desde seeder',
                'valuador' => User::where('valuador', 1)->inRandomOrder()->first()->id
            ]);

            AsignarCuenta::create([
                'localidad' => $oficina->localidad,
                'oficina' => $oficina->oficina,
                'tipo_predio' => 2,
                'numero_registro' => 1,
                'estatus' => 1,
                'observaciones' => 'Origen desde seeder',
                'valuador' => User::where('valuador', 1)->inRandomOrder()->first()->id
            ]);

        }

    }
}
