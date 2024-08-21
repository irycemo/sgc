<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Predio;
use App\Models\Propietario;
use App\Models\AsignarCuenta;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PredioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Predio::factory(1000)->create()->each(function(Predio $predio){

            AsignarCuenta::create([
                'localidad' => $predio->localidad,
                'oficina' => $predio->oficina,
                'tipo_predio' => $predio->tipo_predio,
                'numero_registro' => $predio->numero_registro,
                'estatus' => 1,
                'observaciones' => 'Origen desde seeder',
                'valuador' => User::where('valuador', 1)->inRandomOrder()->first()->id
            ]);

            Propietario::factory(2)->create([
                'propietarioable_id' => $predio->id,
                'propietarioable_type' => 'App\Models\Predio'
            ]);

        });
    }
}
