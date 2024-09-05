<?php

namespace Database\Seeders;

use App\Models\Tramite;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tramite::factory(100)->create();
    }
}
