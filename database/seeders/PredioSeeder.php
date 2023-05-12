<?php

namespace Database\Seeders;

use App\Models\Predio;
use App\Models\Propietario;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PredioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Predio::factory(100)->has(Propietario::factory(2))->create();
    }
}
