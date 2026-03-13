<?php

namespace Database\Seeders;

use App\Models\Efirma;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EfirmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Efirma::create([
            'user_id' => 7,
            'estado' => 'activo',
            'cer' => '9QshK51nRcSrs5bDo2mG2f6sojjQ1mdlsfn7UPe7.cer',
            'key' => 'C4Cfz8LvDyL9DeK7Ys9pATUKT70iSMbBj6Xj4MUL.key',
            'contraseña' => '3UKF1275',
            'imagen' => 'AXmaU4GwU9oLue9292HPAFohbYz6Bf1lk988yHKG.png'
        ]);

        Efirma::create([
            'user_id' => 8,
            'estado' => 'activo',
            'cer' => 'fgk576MwZycP5lot0Fk5eb7RfO9LNLmMjXvYtN2N.cer',
            'key' => 'piey4Ci6MjxHwreNK45Y2pFwCooCrB2oH6vbLmRD.key',
            'contraseña' => 'kiabeth1',
        ]);

    }
}
