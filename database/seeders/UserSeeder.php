<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Enrique',
            'ap_paterno' => 'Robledo',
            'ap_materno' => 'Camacho',
            'oficina' => '101',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrador');
    }
}
