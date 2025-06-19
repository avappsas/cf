<?php // database/seeders/CiudadesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ciudades')->insert([
            [
                'Provincia' => 'Provincia Uno',
                'Ciudad' => 'Ciudad Uno',
            ],
            [
                'Provincia' => 'Provincia Dos',
                'Ciudad' => 'Ciudad Dos',
            ],
            // Agrega más ciudades según sea necesario
        ]);
    }
}