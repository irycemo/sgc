<?php

namespace Database\Seeders;

use App\Models\CategoriaServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaServicio::create([
            'id' => 13,
            'nombre' => 'Autorización e inscripción de peritos valuadores de bienes inmuebles',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 21,
            'nombre' => 'Aviso Aclaratorio',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 19,
            'nombre' => 'Cédula de actualización',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 4,
            'nombre' => 'Certificaciones catastrales',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 10,
            'nombre' => 'Desglose de predios y valuación',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 7,
            'nombre' => 'Determinación de la ubicación física de predios',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 16,
            'nombre' => 'Expedición de duplicados de documentos catastrales',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 5,
            'nombre' => 'Expedición de planos catastrales',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 26,
            'nombre' => 'Georreferenciación de croquis administrativos del catastro',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 14,
            'nombre' => 'Información a propietarios o poseedores de predios registrados',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 22,
            'nombre' => 'Inscripción Catastral para Registro de Predios por Regularizar',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 8,
            'nombre' => 'Inspecciones Oculares',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 17,
            'nombre' => 'Levantamiento Topográfico con curvas de nivel',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 23,
            'nombre' => 'Levantamientos aerofotogramétricos y otros servicios de alta precisión',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 6,
            'nombre' => 'Levantamientos topográficos',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 18,
            'nombre' => 'Modificación de datos administrativos catastrales',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 12,
            'nombre' => 'Predio Ignorado',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 9,
            'nombre' => 'Reestructuración de cuentas catastrales',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 20,
            'nombre' => 'Revisión de Aviso y/o cancelación',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 11,
            'nombre' => 'Solicitud de Variación Catastral',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 24,
            'nombre' => 'Ubicación cartográfica para la asignación correcta de clave catastral',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 25,
            'nombre' => 'Ubicación cartográfica por cambio de localidad',
            'operacion_principal' => 2403
        ]);

        CategoriaServicio::create([
            'id' => 15,
            'nombre' => 'Ubicación de predios en cartografía',
            'operacion_principal' => 2403
        ]);
    }
}
