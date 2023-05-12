<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PredioSeeder;
use Database\Seeders\TramiteSeeder;
use Database\Seeders\CategoriaServicioSeeder;

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
        $this->call(Userseeder::class);
        $this->call(CategoriaServicioSeeder::class);
        $this->call(ServiciosTableSeeder::class);
        $this->call(TramiteSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(PredioSeeder::class);
    }
}
