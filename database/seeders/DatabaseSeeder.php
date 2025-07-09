<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\EfirmaSeeder;
use Database\Seeders\NotariaSeeder;
use Database\Seeders\DependenciaSeeder;
use Database\Seeders\OficinasTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UserSeeder::class);
        $this->call(OficinasTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EfirmaSeeder::class);
        $this->call(CategoriaServiciosTableSeeder::class);
        $this->call(ServiciosTableSeeder::class);
        $this->call(UmaSeeder::class);
        $this->call(ValoresUnitariosConstruccionsTableSeeder::class);
        $this->call(ValoresUnitariosRusticosTableSeeder::class);
        $this->call(FactorIncrementosTableSeeder::class);
        $this->call(DependenciaSeeder::class);
        $this->call(NotariaSeeder::class);

    }
}
