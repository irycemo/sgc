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
            'name' => 'Enrique Robledo Camacho',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'enrique_j_@hotmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 2,
            'name' => 'Tomas Hernandez Cuellar',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'tomas.hernandez@plancartemorelia.edu.mx',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 3,
            'name' => 'Martin Cervantes Contreras',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'cervantes.martin@gmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 4,
            'name' => 'Mauricio Landa Herrera',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'mlanda64@hotmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 5,
            'name' => 'Salvador Sanchez Alvarez',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'ssacat@outlook.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 6,
            'name' => 'Saul Hernandez Castro',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'scastro@michoacan.gob.mx',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 7,
            'name' => 'Sergio Arturo Calvillo Corral',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Dirección de Catastro',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Director');

        User::create([
            'clave' => 8,
            'name' => 'Jose Lopez Ayala',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento de Valuación',
            'email' => 'correo3@correo.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Jefe de departamento');

        User::create([
            'clave' => 9,
            'name' => 'Sistema RPP',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'sistemarpp@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Sistemas');

        User::create([
            'clave' => 10,
            'name' => 'Sistema pertios externos',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'sistemaperitosexternos@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Sistemas');

        User::create([
            'clave' => 11,
            'name' => 'Sistema trámites en línea',
            'oficina_id' => '53',
            'estado' => 'activo',
            'area' => 'Departamento De Operación Y Desarrollo De Sistemas',
            'email' => 'sistematramiteslinea@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Sistemas');

        User::create([
            'clave' => 12,
            'oficina_id' => '53',
            'name' => 'Jesus Manriquez Vargas',
            'estado' => 'activo',
            'email' => 'subdirti.irycem@correo.michoacan.gob.mx',
            'password' => Hash::make('sistema'),
            'area' => 'Subdirección de Tecnologías de la Información',
        ])->assignRole('Administrador');

    }
}
