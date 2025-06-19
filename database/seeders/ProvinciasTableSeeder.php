<?php // database/seeders/ProvinciasTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('provincias')->insert([
            [
                'Provincia' => 'Provincia Uno',
                'Pais' => 'País Uno',
            ],
            [
                'Provincia' => 'Provincia Dos',
                'Pais' => 'País Dos',
            ],
            // Agrega más provincias según sea necesario
        ]);
    }
}