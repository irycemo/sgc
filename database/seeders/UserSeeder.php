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
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'correo@correo.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 2,
            'name' => 'Tomas',
            'ap_paterno' => 'Hernandez',
            'ap_materno' => 'Cuellar',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'tomas.hernandez@plancartemorelia.edu.mx',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 3,
            'name' => 'Martin',
            'ap_paterno' => 'Cervantes',
            'ap_materno' => 'Osorio',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'cervantes.martin@gmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 4,
            'name' => 'Mauricio',
            'ap_paterno' => 'Landa',
            'ap_materno' => 'Herrera',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'mlanda64@hotmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 5,
            'name' => 'Salvador',
            'ap_paterno' => 'Sanchez',
            'ap_materno' => 'Alvarez',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'ssacat@outlook.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 6,
            'name' => 'Saul',
            'ap_paterno' => 'Hernandez',
            'ap_materno' => 'Castro',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'scastro@michoacan.gob.mx',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 7,
            'name' => 'Sergio Arturo',
            'ap_paterno' => 'Calvillo',
            'ap_materno' => 'Corral',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Dirección de Catastro',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Director');

        User::create([
            'clave' => 8,
            'name' => 'Martin',
            'ap_paterno' => 'Calvillo',
            'ap_materno' => 'Corral',
            'oficina_id' => '53',
            'status' => 'activo',
            'area' => 'Departamento de Valuación',
            'email' => 'correo3@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Jefe de departamento');

        User::factory(10)->create()->each(function($user){
            $user->assignRole('Valuador');
        });
    }
}
