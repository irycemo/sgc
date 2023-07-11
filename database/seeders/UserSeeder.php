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
            'clave' => 1,
            'name' => 'Enrique',
            'ap_paterno' => 'Robledo',
            'ap_materno' => 'Camacho',
            'oficina' => '101',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 2,
            'name' => 'Sergio Arturo',
            'ap_paterno' => 'Calvillo',
            'ap_materno' => 'Corral',
            'oficina' => '101',
            'status' => 'activo',
            'area' => 'Dirección de Catastro',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Director');

        User::create([
            'clave' => 3,
            'name' => 'Martin',
            'ap_paterno' => 'Calvillo',
            'ap_materno' => 'Corral',
            'oficina' => '101',
            'status' => 'activo',
            'area' => 'Departamento de Valuación',
            'email' => 'correo3@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Jefe de departamento');

        User::factory(20)->create()->each(function($user){
            $user->assignRole('Valuador');
        });
    }
}
