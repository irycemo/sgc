<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ModelHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();

        \DB::table('model_has_permissions')->delete();

        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            1 =>
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            2 =>
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            3 =>
            array (
                'permission_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            4 =>
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            5 =>
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            6 =>
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            7 =>
            array (
                'permission_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            8 =>
            array (
                'permission_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            9 =>
            array (
                'permission_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            10 =>
            array (
                'permission_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            11 =>
            array (
                'permission_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            12 =>
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            13 =>
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            14 =>
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            15 =>
            array (
                'permission_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            16 =>
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            17 =>
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            18 =>
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            19 =>
            array (
                'permission_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            20 =>
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            21 =>
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            22 =>
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            23 =>
            array (
                'permission_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            24 =>
            array (
                'permission_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            25 =>
            array (
                'permission_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            26 =>
            array (
                'permission_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            27 =>
            array (
                'permission_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            28 =>
            array (
                'permission_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            29 =>
            array (
                'permission_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            30 =>
            array (
                'permission_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            31 =>
            array (
                'permission_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            32 =>
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            33 =>
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            34 =>
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            35 =>
            array (
                'permission_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            36 =>
            array (
                'permission_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            37 =>
            array (
                'permission_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            38 =>
            array (
                'permission_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            39 =>
            array (
                'permission_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            40 =>
            array (
                'permission_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            41 =>
            array (
                'permission_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            42 =>
            array (
                'permission_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            43 =>
            array (
                'permission_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            44 =>
            array (
                'permission_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            45 =>
            array (
                'permission_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            46 =>
            array (
                'permission_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            47 =>
            array (
                'permission_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            48 =>
            array (
                'permission_id' => 13,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            49 =>
            array (
                'permission_id' => 13,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            50 =>
            array (
                'permission_id' => 13,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            51 =>
            array (
                'permission_id' => 13,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            52 =>
            array (
                'permission_id' => 14,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            53 =>
            array (
                'permission_id' => 14,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            54 =>
            array (
                'permission_id' => 14,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            55 =>
            array (
                'permission_id' => 14,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            56 =>
            array (
                'permission_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            57 =>
            array (
                'permission_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            58 =>
            array (
                'permission_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            59 =>
            array (
                'permission_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            60 =>
            array (
                'permission_id' => 16,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            61 =>
            array (
                'permission_id' => 16,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            62 =>
            array (
                'permission_id' => 16,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            63 =>
            array (
                'permission_id' => 16,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            64 =>
            array (
                'permission_id' => 17,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            65 =>
            array (
                'permission_id' => 17,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            66 =>
            array (
                'permission_id' => 17,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            67 =>
            array (
                'permission_id' => 17,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            68 =>
            array (
                'permission_id' => 18,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            69 =>
            array (
                'permission_id' => 18,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            70 =>
            array (
                'permission_id' => 18,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            71 =>
            array (
                'permission_id' => 18,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            72 =>
            array (
                'permission_id' => 19,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            73 =>
            array (
                'permission_id' => 19,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            74 =>
            array (
                'permission_id' => 19,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            75 =>
            array (
                'permission_id' => 19,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            76 =>
            array (
                'permission_id' => 20,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            77 =>
            array (
                'permission_id' => 20,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            78 =>
            array (
                'permission_id' => 20,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            79 =>
            array (
                'permission_id' => 20,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            80 =>
            array (
                'permission_id' => 21,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            81 =>
            array (
                'permission_id' => 21,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            82 =>
            array (
                'permission_id' => 21,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            83 =>
            array (
                'permission_id' => 21,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            84 =>
            array (
                'permission_id' => 22,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            85 =>
            array (
                'permission_id' => 22,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            86 =>
            array (
                'permission_id' => 22,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            87 =>
            array (
                'permission_id' => 22,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            88 =>
            array (
                'permission_id' => 23,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            89 =>
            array (
                'permission_id' => 23,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            90 =>
            array (
                'permission_id' => 23,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            91 =>
            array (
                'permission_id' => 23,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            92 =>
            array (
                'permission_id' => 24,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            93 =>
            array (
                'permission_id' => 24,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            94 =>
            array (
                'permission_id' => 24,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            95 =>
            array (
                'permission_id' => 24,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            96 =>
            array (
                'permission_id' => 25,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            97 =>
            array (
                'permission_id' => 25,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            98 =>
            array (
                'permission_id' => 25,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            99 =>
            array (
                'permission_id' => 25,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            100 =>
            array (
                'permission_id' => 26,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            101 =>
            array (
                'permission_id' => 26,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            102 =>
            array (
                'permission_id' => 26,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            103 =>
            array (
                'permission_id' => 26,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            104 =>
            array (
                'permission_id' => 27,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            105 =>
            array (
                'permission_id' => 27,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            106 =>
            array (
                'permission_id' => 27,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            107 =>
            array (
                'permission_id' => 27,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            108 =>
            array (
                'permission_id' => 28,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            109 =>
            array (
                'permission_id' => 28,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            110 =>
            array (
                'permission_id' => 28,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            111 =>
            array (
                'permission_id' => 28,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            112 =>
            array (
                'permission_id' => 29,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            113 =>
            array (
                'permission_id' => 29,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            114 =>
            array (
                'permission_id' => 29,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            115 =>
            array (
                'permission_id' => 29,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            116 =>
            array (
                'permission_id' => 30,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            117 =>
            array (
                'permission_id' => 30,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            118 =>
            array (
                'permission_id' => 30,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            119 =>
            array (
                'permission_id' => 30,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            120 =>
            array (
                'permission_id' => 31,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            121 =>
            array (
                'permission_id' => 31,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            122 =>
            array (
                'permission_id' => 31,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            123 =>
            array (
                'permission_id' => 31,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            124 =>
            array (
                'permission_id' => 32,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            125 =>
            array (
                'permission_id' => 32,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            126 =>
            array (
                'permission_id' => 32,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            127 =>
            array (
                'permission_id' => 32,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            128 =>
            array (
                'permission_id' => 33,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            129 =>
            array (
                'permission_id' => 33,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            130 =>
            array (
                'permission_id' => 33,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            131 =>
            array (
                'permission_id' => 33,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            132 =>
            array (
                'permission_id' => 34,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            133 =>
            array (
                'permission_id' => 34,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            134 =>
            array (
                'permission_id' => 34,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            135 =>
            array (
                'permission_id' => 34,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            136 =>
            array (
                'permission_id' => 35,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            137 =>
            array (
                'permission_id' => 35,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            138 =>
            array (
                'permission_id' => 35,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            139 =>
            array (
                'permission_id' => 35,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            140 =>
            array (
                'permission_id' => 36,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            141 =>
            array (
                'permission_id' => 36,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            142 =>
            array (
                'permission_id' => 36,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            143 =>
            array (
                'permission_id' => 36,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            144 =>
            array (
                'permission_id' => 37,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            145 =>
            array (
                'permission_id' => 37,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            146 =>
            array (
                'permission_id' => 37,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            147 =>
            array (
                'permission_id' => 37,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            148 =>
            array (
                'permission_id' => 38,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            149 =>
            array (
                'permission_id' => 38,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            150 =>
            array (
                'permission_id' => 38,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            151 =>
            array (
                'permission_id' => 38,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            152 =>
            array (
                'permission_id' => 39,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            153 =>
            array (
                'permission_id' => 39,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            154 =>
            array (
                'permission_id' => 39,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            155 =>
            array (
                'permission_id' => 39,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            156 =>
            array (
                'permission_id' => 40,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            157 =>
            array (
                'permission_id' => 40,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            158 =>
            array (
                'permission_id' => 40,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            159 =>
            array (
                'permission_id' => 40,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            160 =>
            array (
                'permission_id' => 41,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            161 =>
            array (
                'permission_id' => 41,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            162 =>
            array (
                'permission_id' => 41,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            163 =>
            array (
                'permission_id' => 41,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            164 =>
            array (
                'permission_id' => 42,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            165 =>
            array (
                'permission_id' => 42,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            166 =>
            array (
                'permission_id' => 42,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            167 =>
            array (
                'permission_id' => 42,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            168 =>
            array (
                'permission_id' => 43,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            169 =>
            array (
                'permission_id' => 43,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            170 =>
            array (
                'permission_id' => 43,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            171 =>
            array (
                'permission_id' => 43,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            172 =>
            array (
                'permission_id' => 44,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            173 =>
            array (
                'permission_id' => 44,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            174 =>
            array (
                'permission_id' => 44,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            175 =>
            array (
                'permission_id' => 44,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            176 =>
            array (
                'permission_id' => 45,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            177 =>
            array (
                'permission_id' => 45,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            178 =>
            array (
                'permission_id' => 45,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            179 =>
            array (
                'permission_id' => 45,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            180 =>
            array (
                'permission_id' => 46,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            181 =>
            array (
                'permission_id' => 46,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            182 =>
            array (
                'permission_id' => 46,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            183 =>
            array (
                'permission_id' => 46,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            184 =>
            array (
                'permission_id' => 47,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            185 =>
            array (
                'permission_id' => 47,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            186 =>
            array (
                'permission_id' => 47,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            187 =>
            array (
                'permission_id' => 47,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            188 =>
            array (
                'permission_id' => 48,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            189 =>
            array (
                'permission_id' => 48,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            190 =>
            array (
                'permission_id' => 48,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            191 =>
            array (
                'permission_id' => 48,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            192 =>
            array (
                'permission_id' => 49,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            193 =>
            array (
                'permission_id' => 49,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            194 =>
            array (
                'permission_id' => 49,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            195 =>
            array (
                'permission_id' => 49,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            196 =>
            array (
                'permission_id' => 50,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            197 =>
            array (
                'permission_id' => 50,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            198 =>
            array (
                'permission_id' => 50,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            199 =>
            array (
                'permission_id' => 50,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            200 =>
            array (
                'permission_id' => 51,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            201 =>
            array (
                'permission_id' => 51,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            202 =>
            array (
                'permission_id' => 51,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            203 =>
            array (
                'permission_id' => 51,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            204 =>
            array (
                'permission_id' => 52,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            205 =>
            array (
                'permission_id' => 52,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            206 =>
            array (
                'permission_id' => 52,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            207 =>
            array (
                'permission_id' => 52,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            208 =>
            array (
                'permission_id' => 53,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            209 =>
            array (
                'permission_id' => 53,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            210 =>
            array (
                'permission_id' => 53,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            211 =>
            array (
                'permission_id' => 53,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            212 =>
            array (
                'permission_id' => 54,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            213 =>
            array (
                'permission_id' => 54,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            214 =>
            array (
                'permission_id' => 54,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            215 =>
            array (
                'permission_id' => 54,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            216 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            217 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            218 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            219 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            220 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            221 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            222 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            223 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            224 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            225 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            226 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            227 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            228 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            229 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            230 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            231 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            232 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            233 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            234 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            235 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            236 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            237 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            238 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            239 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            240 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            241 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            242 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            243 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            244 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            245 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            246 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            247 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            248 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            249 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            250 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            251 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            252 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            253 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            254 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            255 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            256 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            257 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            258 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            259 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            260 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            261 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            262 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            263 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            264 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            265 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            266 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            267 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            268 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            269 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            270 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            271 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            272 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            273 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            274 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            275 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            276 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            277 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            278 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            279 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            280 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            281 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            282 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            283 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            284 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            285 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            286 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            287 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            288 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            289 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            290 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            291 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            292 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            293 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            294 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            295 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            296 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            297 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            298 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            299 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            300 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            301 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            302 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            303 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            304 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            305 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            306 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            307 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            308 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            309 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            310 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            311 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            312 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            313 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            314 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            315 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            316 =>
            array (
                'permission_id' => 55,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            317 =>
            array (
                'permission_id' => 56,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            318 =>
            array (
                'permission_id' => 56,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            319 =>
            array (
                'permission_id' => 56,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            320 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            321 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            322 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            323 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            324 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            325 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            326 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            327 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            328 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            329 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            330 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            331 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            332 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            333 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            334 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            335 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            336 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            337 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            338 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            339 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            340 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            341 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            342 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            343 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            344 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            345 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            346 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            347 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            348 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            349 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            350 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            351 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            352 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            353 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            354 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            355 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            356 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            357 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            358 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            359 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            360 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            361 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            362 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            363 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            364 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            365 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            366 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            367 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            368 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            369 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            370 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            371 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            372 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            373 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            374 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            375 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            376 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            377 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            378 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            379 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            380 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            381 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            382 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            383 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            384 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            385 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            386 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            387 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            388 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            389 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            390 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            391 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            392 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            393 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            394 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            395 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            396 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            397 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            398 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            399 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            400 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            401 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            402 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            403 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            404 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            405 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            406 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            407 =>
            array (
                'permission_id' => 57,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            408 =>
            array (
                'permission_id' => 58,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            409 =>
            array (
                'permission_id' => 58,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            410 =>
            array (
                'permission_id' => 58,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            411 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            412 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            413 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            414 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            415 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            416 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            417 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            418 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            419 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            420 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            421 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            422 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            423 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            424 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            425 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            426 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            427 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            428 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            429 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            430 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            431 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            432 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            433 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            434 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            435 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            436 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            437 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            438 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            439 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            440 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            441 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            442 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            443 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            444 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            445 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            446 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            447 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            448 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            449 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            450 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            451 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            452 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            453 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            454 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            455 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            456 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            457 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            458 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            459 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            460 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            461 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            462 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            463 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            464 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            465 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            466 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            467 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            468 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            469 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            470 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            471 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            472 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            473 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            474 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            475 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            476 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            477 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            478 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            479 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            480 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            481 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            482 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            483 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            484 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            485 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            486 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            487 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            488 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            489 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            490 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            491 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            492 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            493 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            494 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            495 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            496 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            497 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            498 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            499 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
        ));
        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            1 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            2 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            3 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            4 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            5 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            6 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            7 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            8 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            9 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            10 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            11 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            12 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            13 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            14 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            15 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            16 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            17 =>
            array (
                'permission_id' => 59,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            18 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            19 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            20 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            21 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            22 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            23 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            24 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            25 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            26 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            27 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            28 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            29 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            30 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            31 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            32 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            33 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            34 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            35 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            36 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            37 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            38 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            39 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            40 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            41 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            42 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            43 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            44 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            45 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            46 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            47 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            48 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            49 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            50 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            51 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            52 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            53 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            54 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            55 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            56 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            57 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            58 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            59 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            60 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            61 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            62 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            63 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            64 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            65 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            66 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            67 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            68 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            69 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            70 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            71 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            72 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            73 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            74 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            75 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            76 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            77 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            78 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            79 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            80 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            81 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            82 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            83 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            84 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            85 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            86 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            87 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            88 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            89 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            90 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            91 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            92 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            93 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            94 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            95 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            96 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            97 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            98 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            99 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            100 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            101 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            102 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            103 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            104 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            105 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            106 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            107 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            108 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            109 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            110 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            111 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            112 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            113 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            114 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            115 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            116 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            117 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            118 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            119 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            120 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            121 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            122 =>
            array (
                'permission_id' => 60,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            123 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            124 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            125 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            126 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            127 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            128 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            129 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            130 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            131 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            132 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            133 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            134 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            135 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            136 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            137 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            138 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            139 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            140 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            141 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            142 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            143 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            144 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            145 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            146 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            147 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            148 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            149 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            150 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            151 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            152 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            153 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            154 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            155 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            156 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            157 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            158 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            159 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            160 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            161 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            162 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            163 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            164 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            165 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            166 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            167 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            168 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            169 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            170 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            171 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            172 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            173 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            174 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            175 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            176 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            177 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            178 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            179 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            180 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            181 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            182 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            183 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            184 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            185 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            186 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            187 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            188 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            189 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            190 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            191 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            192 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            193 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            194 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            195 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            196 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            197 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            198 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            199 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            200 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            201 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            202 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            203 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            204 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            205 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            206 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            207 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            208 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            209 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            210 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            211 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            212 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            213 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            214 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            215 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            216 =>
            array (
                'permission_id' => 61,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            217 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            218 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            219 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            220 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            221 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            222 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            223 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            224 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            225 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            226 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            227 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            228 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            229 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            230 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            231 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            232 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            233 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            234 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            235 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            236 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            237 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            238 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            239 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            240 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            241 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            242 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            243 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            244 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            245 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            246 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            247 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            248 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            249 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            250 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            251 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            252 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            253 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            254 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            255 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            256 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            257 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            258 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            259 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            260 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            261 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            262 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            263 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            264 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            265 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            266 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            267 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            268 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            269 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            270 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            271 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            272 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            273 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            274 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            275 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            276 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            277 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            278 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            279 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            280 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            281 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            282 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            283 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            284 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            285 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            286 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            287 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            288 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            289 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            290 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            291 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            292 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            293 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            294 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            295 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            296 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            297 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            298 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            299 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            300 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            301 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            302 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            303 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            304 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            305 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            306 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            307 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            308 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            309 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            310 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            311 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            312 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            313 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            314 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            315 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            316 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            317 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            318 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            319 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            320 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            321 =>
            array (
                'permission_id' => 62,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            322 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            323 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            324 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            325 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            326 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            327 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            328 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            329 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            330 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            331 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            332 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            333 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            334 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            335 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            336 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            337 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            338 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            339 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            340 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            341 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            342 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            343 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            344 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            345 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            346 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            347 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            348 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            349 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            350 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            351 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            352 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            353 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            354 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            355 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            356 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            357 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            358 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            359 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            360 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            361 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            362 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            363 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            364 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            365 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            366 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            367 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            368 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            369 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            370 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            371 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            372 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            373 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            374 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            375 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            376 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            377 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            378 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            379 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            380 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            381 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            382 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            383 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            384 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            385 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            386 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            387 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            388 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            389 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            390 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            391 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            392 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            393 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            394 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            395 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            396 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            397 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            398 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            399 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            400 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            401 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            402 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            403 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            404 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            405 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            406 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            407 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            408 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            409 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            410 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            411 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            412 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            413 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            414 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            415 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            416 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            417 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            418 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            419 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            420 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            421 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            422 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            423 =>
            array (
                'permission_id' => 63,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            424 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            425 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            426 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            427 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            428 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            429 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            430 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            431 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            432 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            433 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            434 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            435 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            436 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            437 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            438 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            439 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            440 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            441 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            442 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            443 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            444 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            445 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            446 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            447 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            448 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            449 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            450 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            451 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            452 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            453 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            454 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            455 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            456 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            457 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            458 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            459 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            460 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            461 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            462 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            463 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            464 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            465 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            466 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            467 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            468 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            469 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            470 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            471 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            472 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            473 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            474 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            475 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            476 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            477 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            478 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            479 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            480 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            481 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            482 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            483 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            484 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            485 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            486 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            487 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            488 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            489 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            490 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            491 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            492 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            493 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            494 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            495 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            496 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            497 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            498 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            499 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
        ));
        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            1 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            2 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            3 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            4 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            5 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            6 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            7 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            8 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            9 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            10 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            11 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            12 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            13 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            14 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            15 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            16 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            17 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            18 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            19 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            20 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            21 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            22 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            23 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            24 =>
            array (
                'permission_id' => 64,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            25 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            26 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            27 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            28 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            29 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            30 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            31 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            32 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            33 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            34 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            35 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            36 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            37 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            38 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            39 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            40 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            41 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            42 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            43 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            44 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            45 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            46 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            47 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            48 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            49 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            50 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            51 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            52 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            53 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            54 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            55 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            56 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            57 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            58 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            59 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            60 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            61 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            62 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            63 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            64 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            65 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            66 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            67 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            68 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            69 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            70 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            71 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            72 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            73 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            74 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            75 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            76 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            77 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            78 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            79 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            80 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            81 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            82 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            83 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            84 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            85 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            86 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            87 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            88 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            89 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            90 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            91 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            92 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            93 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            94 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            95 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            96 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            97 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            98 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            99 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            100 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            101 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            102 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            103 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            104 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            105 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            106 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            107 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            108 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            109 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            110 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            111 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            112 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            113 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            114 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            115 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            116 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            117 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            118 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            119 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            120 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            121 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            122 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            123 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            124 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            125 =>
            array (
                'permission_id' => 65,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            126 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            127 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            128 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            129 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            130 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            131 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            132 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            133 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            134 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            135 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            136 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            137 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            138 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            139 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            140 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            141 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            142 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            143 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            144 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            145 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            146 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            147 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            148 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            149 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            150 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            151 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            152 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            153 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            154 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            155 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            156 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            157 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            158 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            159 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            160 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            161 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            162 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            163 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            164 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            165 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            166 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            167 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            168 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            169 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            170 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            171 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            172 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            173 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            174 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            175 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            176 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            177 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            178 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            179 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            180 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            181 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            182 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            183 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            184 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            185 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            186 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            187 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            188 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            189 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            190 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            191 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            192 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            193 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            194 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            195 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            196 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            197 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            198 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            199 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            200 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            201 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            202 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            203 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            204 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            205 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            206 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            207 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            208 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            209 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            210 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            211 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            212 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            213 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            214 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            215 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            216 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            217 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            218 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            219 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            220 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            221 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            222 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            223 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            224 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            225 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            226 =>
            array (
                'permission_id' => 66,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            227 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            228 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            229 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            230 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            231 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            232 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            233 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            234 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            235 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            236 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            237 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            238 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            239 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            240 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            241 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            242 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            243 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            244 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            245 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            246 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            247 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            248 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            249 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            250 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            251 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            252 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            253 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            254 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            255 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            256 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            257 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            258 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            259 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            260 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            261 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            262 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            263 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            264 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            265 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            266 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            267 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            268 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            269 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            270 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            271 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            272 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            273 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            274 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            275 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            276 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            277 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            278 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            279 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            280 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            281 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            282 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            283 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            284 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            285 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            286 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            287 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            288 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            289 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            290 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            291 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            292 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            293 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            294 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            295 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            296 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            297 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            298 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            299 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            300 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            301 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            302 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            303 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            304 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            305 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            306 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            307 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            308 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            309 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            310 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            311 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            312 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            313 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            314 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            315 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            316 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            317 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            318 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            319 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            320 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            321 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            322 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            323 =>
            array (
                'permission_id' => 67,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            324 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            325 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            326 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            327 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            328 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            329 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            330 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            331 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            332 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            333 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            334 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            335 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            336 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            337 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            338 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            339 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            340 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            341 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            342 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            343 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            344 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            345 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            346 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            347 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            348 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            349 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            350 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            351 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            352 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            353 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            354 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            355 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            356 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            357 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            358 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            359 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            360 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            361 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            362 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            363 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            364 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            365 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            366 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            367 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            368 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            369 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            370 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            371 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            372 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            373 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            374 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            375 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            376 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            377 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            378 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            379 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            380 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            381 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            382 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            383 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            384 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            385 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            386 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            387 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            388 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            389 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            390 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            391 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            392 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            393 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            394 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            395 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            396 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            397 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            398 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            399 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            400 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            401 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            402 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            403 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            404 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            405 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            406 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            407 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            408 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            409 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            410 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            411 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            412 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            413 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            414 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            415 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            416 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            417 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            418 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            419 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            420 =>
            array (
                'permission_id' => 68,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            421 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            422 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            423 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            424 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            425 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            426 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            427 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            428 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            429 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            430 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            431 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            432 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            433 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            434 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            435 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            436 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            437 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            438 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            439 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            440 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            441 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            442 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            443 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            444 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            445 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            446 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            447 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            448 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            449 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            450 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            451 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            452 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            453 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            454 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            455 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            456 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            457 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            458 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            459 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            460 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            461 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            462 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            463 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            464 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            465 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            466 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            467 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            468 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            469 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            470 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            471 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            472 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            473 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            474 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            475 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            476 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            477 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            478 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            479 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            480 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            481 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            482 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            483 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            484 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            485 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            486 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            487 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            488 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            489 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            490 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            491 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            492 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            493 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            494 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            495 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            496 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            497 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            498 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            499 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
        ));
        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            1 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            2 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            3 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            4 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            5 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            6 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            7 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            8 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            9 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            10 =>
            array (
                'permission_id' => 69,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            11 =>
            array (
                'permission_id' => 70,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            12 =>
            array (
                'permission_id' => 70,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            13 =>
            array (
                'permission_id' => 70,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            14 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            15 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            16 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            17 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            18 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            19 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            20 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            21 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            22 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            23 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            24 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            25 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            26 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            27 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            28 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            29 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            30 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            31 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            32 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            33 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            34 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            35 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            36 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            37 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            38 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            39 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            40 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            41 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            42 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            43 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            44 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            45 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            46 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            47 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            48 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            49 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            50 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            51 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            52 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            53 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            54 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            55 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            56 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            57 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            58 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            59 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            60 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            61 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            62 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            63 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            64 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            65 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            66 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            67 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            68 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            69 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            70 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            71 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            72 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            73 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            74 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            75 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            76 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            77 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            78 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            79 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            80 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            81 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            82 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            83 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            84 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            85 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            86 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            87 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            88 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            89 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            90 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            91 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            92 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            93 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            94 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            95 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            96 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            97 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            98 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            99 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            100 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            101 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            102 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            103 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            104 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            105 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            106 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            107 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            108 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            109 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            110 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            111 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            112 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            113 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            114 =>
            array (
                'permission_id' => 71,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            115 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            116 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            117 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            118 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            119 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            120 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            121 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            122 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            123 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            124 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            125 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            126 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            127 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            128 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            129 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            130 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            131 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            132 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            133 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            134 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            135 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            136 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            137 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            138 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            139 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            140 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            141 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            142 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            143 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            144 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            145 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            146 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            147 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            148 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            149 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            150 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            151 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            152 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            153 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            154 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            155 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            156 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            157 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            158 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            159 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            160 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            161 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            162 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            163 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            164 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            165 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            166 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            167 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            168 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            169 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            170 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            171 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            172 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            173 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            174 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            175 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            176 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            177 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            178 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            179 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            180 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            181 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            182 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            183 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            184 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            185 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            186 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            187 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            188 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            189 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            190 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            191 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            192 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            193 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            194 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            195 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            196 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            197 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            198 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            199 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            200 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            201 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            202 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            203 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            204 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            205 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            206 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            207 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            208 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            209 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            210 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            211 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            212 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            213 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            214 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            215 =>
            array (
                'permission_id' => 72,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            216 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            217 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            218 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            219 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            220 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            221 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            222 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            223 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            224 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            225 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            226 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            227 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            228 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            229 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            230 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            231 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            232 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            233 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            234 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            235 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            236 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            237 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            238 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            239 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            240 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            241 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            242 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            243 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            244 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            245 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            246 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            247 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            248 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            249 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            250 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            251 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            252 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            253 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            254 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            255 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            256 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            257 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            258 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            259 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            260 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            261 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            262 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            263 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            264 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            265 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            266 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            267 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            268 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            269 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            270 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            271 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            272 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            273 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            274 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            275 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            276 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            277 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            278 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            279 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            280 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            281 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            282 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            283 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            284 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            285 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            286 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            287 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            288 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            289 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            290 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            291 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            292 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            293 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            294 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            295 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            296 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            297 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            298 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            299 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            300 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            301 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            302 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            303 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            304 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            305 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            306 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            307 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            308 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            309 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            310 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            311 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            312 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            313 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            314 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            315 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            316 =>
            array (
                'permission_id' => 73,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            317 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            318 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            319 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            320 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            321 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            322 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            323 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            324 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            325 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            326 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            327 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            328 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            329 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            330 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            331 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            332 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            333 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            334 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            335 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            336 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            337 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            338 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            339 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            340 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            341 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            342 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            343 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            344 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            345 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            346 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            347 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            348 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            349 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            350 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            351 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            352 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            353 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            354 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            355 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            356 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            357 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            358 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            359 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            360 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            361 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            362 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            363 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            364 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            365 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            366 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            367 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            368 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            369 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            370 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            371 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            372 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            373 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            374 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            375 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            376 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            377 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            378 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            379 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            380 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            381 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            382 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            383 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            384 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            385 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            386 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            387 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            388 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            389 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            390 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            391 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            392 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            393 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            394 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            395 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            396 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            397 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            398 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            399 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            400 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            401 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            402 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            403 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            404 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            405 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            406 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            407 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            408 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            409 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            410 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            411 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            412 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            413 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            414 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            415 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            416 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            417 =>
            array (
                'permission_id' => 74,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            418 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            419 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            420 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            421 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            422 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            423 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            424 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            425 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            426 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            427 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            428 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            429 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            430 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            431 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            432 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            433 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            434 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            435 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            436 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            437 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            438 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            439 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            440 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            441 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            442 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            443 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            444 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            445 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            446 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            447 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            448 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            449 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            450 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            451 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            452 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            453 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            454 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            455 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            456 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            457 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            458 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            459 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            460 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            461 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            462 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            463 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            464 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            465 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            466 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            467 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            468 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            469 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            470 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            471 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            472 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            473 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            474 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            475 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            476 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            477 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            478 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            479 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            480 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            481 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            482 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            483 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            484 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            485 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            486 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            487 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            488 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            489 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            490 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            491 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            492 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            493 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            494 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            495 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            496 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            497 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            498 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            499 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
        ));
        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            1 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            2 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            3 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            4 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            5 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            6 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            7 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            8 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            9 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            10 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            11 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            12 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            13 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            14 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            15 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            16 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            17 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            18 =>
            array (
                'permission_id' => 75,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            19 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            20 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            21 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            22 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            23 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            24 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            25 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            26 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            27 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            28 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            29 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            30 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            31 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            32 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            33 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            34 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            35 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            36 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            37 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            38 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            39 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            40 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            41 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            42 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            43 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            44 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            45 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            46 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            47 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            48 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            49 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            50 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            51 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            52 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            53 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            54 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            55 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            56 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            57 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            58 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            59 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            60 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            61 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            62 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            63 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            64 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            65 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            66 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            67 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            68 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            69 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            70 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            71 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            72 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            73 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            74 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            75 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            76 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            77 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            78 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            79 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            80 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            81 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            82 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            83 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            84 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            85 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            86 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            87 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            88 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            89 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            90 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            91 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            92 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            93 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            94 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            95 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            96 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            97 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            98 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            99 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            100 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            101 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            102 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            103 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            104 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            105 =>
            array (
                'permission_id' => 76,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            106 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            107 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            108 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            109 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            110 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            111 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            112 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            113 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            114 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            115 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            116 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            117 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            118 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            119 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            120 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            121 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            122 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            123 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            124 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            125 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            126 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            127 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            128 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            129 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            130 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            131 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            132 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            133 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            134 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            135 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            136 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            137 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            138 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            139 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            140 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            141 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            142 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            143 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            144 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            145 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            146 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            147 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            148 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            149 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            150 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            151 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            152 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            153 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            154 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            155 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            156 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            157 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            158 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            159 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            160 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            161 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            162 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            163 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            164 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            165 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            166 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            167 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            168 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            169 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            170 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            171 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            172 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            173 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            174 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            175 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            176 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            177 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            178 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            179 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            180 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            181 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            182 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            183 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            184 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            185 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            186 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            187 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            188 =>
            array (
                'permission_id' => 77,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            189 =>
            array (
                'permission_id' => 78,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            190 =>
            array (
                'permission_id' => 78,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            191 =>
            array (
                'permission_id' => 78,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            192 =>
            array (
                'permission_id' => 78,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            193 =>
            array (
                'permission_id' => 79,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            194 =>
            array (
                'permission_id' => 79,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            195 =>
            array (
                'permission_id' => 79,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            196 =>
            array (
                'permission_id' => 79,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            197 =>
            array (
                'permission_id' => 80,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            198 =>
            array (
                'permission_id' => 80,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            199 =>
            array (
                'permission_id' => 80,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            200 =>
            array (
                'permission_id' => 80,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            201 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            202 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            203 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            204 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            205 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            206 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            207 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            208 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            209 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            210 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            211 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            212 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            213 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            214 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            215 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            216 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            217 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            218 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            219 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            220 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            221 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            222 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            223 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            224 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            225 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            226 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            227 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            228 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            229 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            230 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            231 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            232 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            233 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            234 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            235 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            236 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            237 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            238 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            239 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            240 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            241 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            242 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            243 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            244 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            245 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            246 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            247 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            248 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            249 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            250 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            251 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            252 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            253 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            254 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            255 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            256 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            257 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            258 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            259 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            260 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            261 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            262 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            263 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            264 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            265 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            266 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            267 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            268 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            269 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            270 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            271 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            272 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            273 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            274 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            275 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            276 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            277 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            278 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            279 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            280 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            281 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            282 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            283 =>
            array (
                'permission_id' => 81,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            284 =>
            array (
                'permission_id' => 82,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            285 =>
            array (
                'permission_id' => 82,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            286 =>
            array (
                'permission_id' => 82,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            287 =>
            array (
                'permission_id' => 82,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            288 =>
            array (
                'permission_id' => 83,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            289 =>
            array (
                'permission_id' => 83,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            290 =>
            array (
                'permission_id' => 83,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            291 =>
            array (
                'permission_id' => 83,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            292 =>
            array (
                'permission_id' => 84,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            293 =>
            array (
                'permission_id' => 84,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            294 =>
            array (
                'permission_id' => 84,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            295 =>
            array (
                'permission_id' => 84,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            296 =>
            array (
                'permission_id' => 85,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            297 =>
            array (
                'permission_id' => 85,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            298 =>
            array (
                'permission_id' => 85,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            299 =>
            array (
                'permission_id' => 85,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            300 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            301 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            302 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            303 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            304 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            305 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            306 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            307 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            308 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            309 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            310 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            311 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            312 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            313 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            314 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            315 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            316 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            317 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            318 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            319 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            320 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            321 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            322 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            323 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            324 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            325 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            326 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            327 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            328 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            329 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            330 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            331 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            332 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            333 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            334 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            335 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            336 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            337 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            338 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            339 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            340 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            341 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            342 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            343 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            344 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            345 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            346 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            347 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            348 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            349 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            350 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            351 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            352 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            353 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            354 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            355 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            356 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            357 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            358 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            359 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            360 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            361 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            362 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            363 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            364 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            365 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            366 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            367 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            368 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            369 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            370 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            371 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            372 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            373 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            374 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            375 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            376 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            377 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            378 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            379 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            380 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            381 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            382 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            383 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            384 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            385 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            386 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            387 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            388 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            389 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            390 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            391 =>
            array (
                'permission_id' => 86,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            392 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            393 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            394 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            395 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            396 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            397 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            398 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            399 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            400 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            401 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            402 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            403 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            404 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            405 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            406 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            407 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            408 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            409 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            410 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            411 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            412 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            413 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            414 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            415 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            416 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            417 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            418 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            419 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            420 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            421 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            422 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            423 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            424 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            425 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            426 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            427 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            428 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            429 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            430 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            431 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            432 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            433 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            434 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            435 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            436 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            437 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            438 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            439 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            440 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            441 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            442 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            443 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            444 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            445 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            446 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            447 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            448 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            449 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            450 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            451 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            452 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            453 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            454 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            455 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            456 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            457 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            458 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            459 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            460 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            461 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            462 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            463 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            464 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            465 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            466 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            467 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            468 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            469 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            470 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            471 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            472 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            473 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            474 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            475 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            476 =>
            array (
                'permission_id' => 87,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            477 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            478 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            479 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            480 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            481 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            482 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            483 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            484 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            485 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            486 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            487 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            488 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            489 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            490 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            491 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            492 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            493 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            494 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            495 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            496 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            497 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            498 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            499 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
        ));
        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            1 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            2 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            3 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            4 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            5 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            6 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            7 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            8 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            9 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            10 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            11 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            12 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            13 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            14 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            15 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            16 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            17 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            18 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            19 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            20 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            21 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            22 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            23 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            24 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            25 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            26 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            27 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            28 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            29 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            30 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            31 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            32 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            33 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            34 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            35 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            36 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            37 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            38 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            39 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            40 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            41 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            42 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            43 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            44 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            45 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            46 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            47 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            48 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            49 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            50 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            51 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            52 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            53 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            54 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            55 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            56 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            57 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            58 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            59 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            60 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            61 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            62 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            63 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            64 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            65 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            66 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            67 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            68 =>
            array (
                'permission_id' => 88,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            69 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            70 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            71 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            72 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            73 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            74 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            75 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            76 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            77 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            78 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            79 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            80 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            81 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            82 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            83 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            84 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            85 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            86 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            87 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            88 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            89 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            90 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            91 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            92 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            93 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            94 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            95 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            96 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            97 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            98 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            99 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            100 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            101 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            102 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            103 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            104 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            105 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            106 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            107 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            108 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            109 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            110 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            111 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            112 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            113 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            114 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            115 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            116 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            117 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            118 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            119 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            120 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            121 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            122 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            123 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            124 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            125 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            126 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            127 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            128 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            129 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            130 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            131 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            132 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            133 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            134 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            135 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            136 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            137 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            138 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            139 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            140 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            141 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            142 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            143 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            144 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            145 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            146 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            147 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            148 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            149 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            150 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            151 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            152 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            153 =>
            array (
                'permission_id' => 89,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            154 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            155 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            156 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            157 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            158 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            159 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            160 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            161 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            162 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            163 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            164 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            165 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            166 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            167 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            168 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            169 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            170 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            171 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            172 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            173 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            174 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            175 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            176 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            177 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            178 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            179 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            180 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            181 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            182 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            183 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            184 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            185 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            186 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            187 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            188 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            189 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            190 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            191 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            192 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            193 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            194 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            195 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            196 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            197 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            198 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            199 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            200 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            201 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            202 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            203 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            204 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            205 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            206 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            207 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            208 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            209 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            210 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            211 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            212 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            213 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            214 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            215 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            216 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            217 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            218 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            219 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            220 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            221 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            222 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            223 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            224 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            225 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            226 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            227 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            228 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            229 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            230 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            231 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            232 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            233 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            234 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            235 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            236 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            237 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            238 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            239 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            240 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            241 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            242 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            243 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            244 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            245 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            246 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            247 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            248 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            249 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            250 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            251 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            252 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            253 =>
            array (
                'permission_id' => 90,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            254 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            255 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            256 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            257 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            258 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            259 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            260 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            261 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            262 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            263 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            264 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            265 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            266 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            267 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            268 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            269 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            270 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            271 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            272 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            273 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            274 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            275 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            276 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            277 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            278 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            279 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            280 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            281 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            282 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            283 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            284 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            285 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            286 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            287 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            288 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            289 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            290 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            291 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            292 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            293 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            294 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            295 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            296 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            297 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            298 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            299 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            300 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            301 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            302 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            303 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            304 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            305 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            306 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            307 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            308 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            309 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            310 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            311 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            312 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            313 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            314 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            315 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            316 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            317 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            318 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            319 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            320 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            321 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            322 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            323 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            324 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            325 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            326 =>
            array (
                'permission_id' => 91,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            327 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            328 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            329 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            330 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            331 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            332 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            333 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            334 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            335 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            336 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            337 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            338 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            339 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            340 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            341 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            342 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            343 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            344 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            345 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            346 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            347 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            348 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            349 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            350 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            351 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            352 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            353 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            354 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            355 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            356 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            357 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            358 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            359 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            360 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            361 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            362 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            363 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            364 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            365 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            366 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            367 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            368 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            369 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            370 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            371 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            372 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            373 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            374 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            375 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            376 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            377 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            378 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            379 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            380 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            381 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            382 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            383 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            384 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            385 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            386 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            387 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            388 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            389 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            390 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            391 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            392 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            393 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            394 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            395 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            396 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            397 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            398 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            399 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            400 =>
            array (
                'permission_id' => 92,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            401 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            402 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            403 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            404 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            405 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            406 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            407 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            408 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            409 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            410 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            411 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            412 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            413 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            414 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            415 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            416 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            417 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            418 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            419 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            420 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            421 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            422 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            423 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            424 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            425 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            426 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            427 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            428 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            429 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            430 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            431 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            432 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            433 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            434 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            435 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            436 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            437 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            438 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            439 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            440 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            441 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            442 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            443 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            444 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            445 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            446 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            447 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            448 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            449 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            450 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            451 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            452 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            453 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            454 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            455 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            456 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            457 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            458 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            459 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            460 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            461 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            462 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            463 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            464 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            465 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            466 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            467 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            468 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            469 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            470 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            471 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            472 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            473 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            474 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            475 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            476 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            477 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            478 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            479 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            480 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            481 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            482 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            483 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            484 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            485 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            486 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            487 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            488 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            489 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            490 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            491 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            492 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            493 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            494 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            495 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            496 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            497 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            498 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            499 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
        ));
        \DB::table('model_has_permissions')->insert(array (
            0 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            1 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            2 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            3 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            4 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            5 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            6 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            7 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            8 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            9 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            10 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            11 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            12 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            13 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            14 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            15 =>
            array (
                'permission_id' => 93,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            16 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            17 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            18 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            19 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            20 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            21 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            22 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            23 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            24 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            25 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            26 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            27 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            28 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            29 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            30 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            31 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            32 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            33 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            34 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            35 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            36 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            37 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            38 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            39 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            40 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            41 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            42 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            43 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            44 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            45 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            46 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            47 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            48 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            49 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            50 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            51 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            52 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            53 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            54 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            55 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            56 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            57 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            58 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            59 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            60 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            61 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            62 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            63 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            64 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            65 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            66 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            67 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            68 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            69 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            70 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            71 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            72 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            73 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            74 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            75 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            76 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            77 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            78 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            79 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            80 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            81 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            82 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            83 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            84 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            85 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            86 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            87 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            88 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            89 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            90 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            91 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            92 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            93 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            94 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            95 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            96 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            97 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            98 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            99 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            100 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            101 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            102 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            103 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            104 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            105 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            106 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            107 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            108 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            109 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            110 =>
            array (
                'permission_id' => 94,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
        ));

        Schema::enableForeignKeyConstraints();

    }
}
