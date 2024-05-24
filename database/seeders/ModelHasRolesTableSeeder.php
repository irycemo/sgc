<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();

        \DB::table('model_has_roles')->delete();

        \DB::table('model_has_roles')->insert(array (
            0 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            1 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 2,
            ),
            2 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            3 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 4,
            ),
            4 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 5,
            ),
            5 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 6,
            ),
            6 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 12,
            ),
            7 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            8 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            9 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            10 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            11 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            12 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            13 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            14 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            15 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            16 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            17 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            18 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            19 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            20 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            21 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            22 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            23 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            24 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            25 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            26 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            27 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            28 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            29 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            30 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            31 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            32 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            33 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            34 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            35 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            36 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            37 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            38 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            39 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            40 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            41 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            42 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            43 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            44 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            45 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            46 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            47 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            48 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            49 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            50 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            51 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            52 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            53 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            54 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            55 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            56 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            57 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            58 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            59 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            60 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            61 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            62 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            63 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            64 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            65 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            66 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            67 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            68 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            69 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            70 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            71 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            72 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            73 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            74 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            75 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            76 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            77 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            78 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            79 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            80 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            81 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            82 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            83 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            84 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            85 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            86 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            87 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            88 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            89 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            90 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            91 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            92 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            93 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            94 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            95 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            96 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            97 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            98 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            99 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            100 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            101 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            102 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            103 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            104 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            105 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            106 =>
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 13,
            ),
            107 =>
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            108 =>
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 7,
            ),
            109 =>
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9,
            ),
            110 =>
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 10,
            ),
            111 =>
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 11,
            ),
            112 =>
            array (
                'role_id' => 8,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            113 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            114 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            115 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            116 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            117 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            118 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            119 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            120 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            121 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            122 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            123 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            124 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 125,
            ),
            125 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            126 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            127 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            128 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            129 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            130 =>
            array (
                'role_id' => 9,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
        ));

        Schema::enableForeignKeyConstraints();

    }
}
