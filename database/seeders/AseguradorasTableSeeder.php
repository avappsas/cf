<?php
// database/seeders/AseguradorasTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AseguradorasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('aseguradoras')->insert([
            [
                'Aseguradora' => 'Seguros XYZ',
                'id_Ramo' => 1,
            ],
            [
                'Aseguradora' => 'Seguros ABC',
                'id_Ramo' => 2,
            ],
            // Agrega más aseguradoras según sea necesario
        ]);
    }
}