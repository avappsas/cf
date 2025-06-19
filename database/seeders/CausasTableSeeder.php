<?php // database/seeders/CausasTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CausasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('causas')->insert([
            [
                'id_ramo' => 1,
                'Causa' => 'Accidente de tránsito',
            ],
            [
                'id_ramo' => 2,
                'Causa' => 'Enfermedad grave',
            ],
            // Agrega más causas según sea necesario
        ]);
    }
}