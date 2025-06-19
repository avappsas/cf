<?php
// database/seeders/BienesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BienesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bienes')->insert([
            [
                'id_Caso' => 1,
                'Bien_Asegurado' => 'Auto XYZ',
                'Objeto' => 1,
                'Tipo' => 1,
                'Caracteristicas' => 'Color rojo, modelo 2020',
                'Fotos' => 'foto1.jpg',
                'Detalles' => 'Ninguno',
                'objeto_id' => 1,
            ],
            // Agrega más bienes según sea necesario
        ]);
    }
}