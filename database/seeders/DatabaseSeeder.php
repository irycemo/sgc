<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\UmaSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PredioSeeder;
use Database\Seeders\NotariaSeeder;
use Database\Seeders\TramiteSeeder;
use Database\Seeders\DependenciaSeeder;
use Database\Seeders\ServiciosTableSeeder;
use Database\Seeders\CodigoPostalsTableSeeder;
use Database\Seeders\CategoriaServiciosTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(OficinasTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategoriaServiciosTableSeeder::class);
        $this->call(ServiciosTableSeeder::class);
        $this->call(TramiteSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(PredioSeeder::class);
        $this->call(UmaSeeder::class);
        $this->call(ValoresUnitariosConstruccionsTableSeeder::class);
        $this->call(ValoresUnitariosRusticosTableSeeder::class);
        $this->call(DependenciaSeeder::class);
        $this->call(NotariaSeeder::class);
        $this->call(FactorIncrementosTableSeeder::class);
        $this->call(CodigoPostalsTableSeeder::class);
    }
}
