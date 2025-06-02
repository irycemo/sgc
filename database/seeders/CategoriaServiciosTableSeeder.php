<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriaServiciosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categoria_servicios')->delete();
        
        \DB::table('categoria_servicios')->insert(array (
            0 => 
            array (
                'id' => 4,
                'nombre' => 'Certificaciones catastrales',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            1 => 
            array (
                'id' => 5,
                'nombre' => 'Expedición de planos catastrales',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            2 => 
            array (
                'id' => 6,
                'nombre' => 'Levantamientos topográficos',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            3 => 
            array (
                'id' => 7,
                'nombre' => 'Determinación de la ubicación física de predios',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            4 => 
            array (
                'id' => 8,
                'nombre' => 'Inspecciones Oculares',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            5 => 
            array (
                'id' => 9,
                'nombre' => 'Reestructuración de cuentas catastrales',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            6 => 
            array (
                'id' => 10,
                'nombre' => 'Desglose de predios y valuación',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            7 => 
            array (
                'id' => 11,
                'nombre' => 'Solicitud de Variación Catastral',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            8 => 
            array (
                'id' => 12,
                'nombre' => 'Predio Ignorado',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            9 => 
            array (
                'id' => 13,
                'nombre' => 'Autorización e inscripción de peritos valuadores de bienes inmuebles',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            10 => 
            array (
                'id' => 14,
                'nombre' => 'Información a propietarios o poseedores de predios registrados',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            11 => 
            array (
                'id' => 15,
                'nombre' => 'Ubicación de predios en cartografía',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            12 => 
            array (
                'id' => 16,
                'nombre' => 'Expedición de duplicados de documentos catastrales',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            13 => 
            array (
                'id' => 17,
                'nombre' => 'Levantamiento Topográfico con curvas de nivel',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            14 => 
            array (
                'id' => 18,
                'nombre' => 'Modificación de datos administrativos catastrales',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            15 => 
            array (
                'id' => 19,
                'nombre' => 'Cédula de actualización',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            16 => 
            array (
                'id' => 20,
                'nombre' => 'Revisión de Aviso y/o cancelación',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            17 => 
            array (
                'id' => 21,
                'nombre' => 'Aviso Aclaratorio',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            18 => 
            array (
                'id' => 22,
                'nombre' => 'Inscripción Catastral para Registro de Predios por Regularizar',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            19 => 
            array (
                'id' => 23,
                'nombre' => 'Levantamientos aerofotogramétricos y otros servicios de alta precisión',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            20 => 
            array (
                'id' => 24,
                'nombre' => 'Ubicación cartográfica para la asignación correcta de clave catastral',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            21 => 
            array (
                'id' => 25,
                'nombre' => 'Ubicación cartográfica por cambio de localidad',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
            22 => 
            array (
                'id' => 26,
                'nombre' => 'Georreferenciación de croquis administrativos del catastro',
                'creado_por' => NULL,
                'actualizado_por' => NULL,
                'created_at' => '2023-05-18 12:08:56',
                'updated_at' => '2023-05-18 12:08:56',
            ),
        ));
        
        
    }
}