<?php // database/seeders/RamosTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RamosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ramos')->insert([
            [
                'ramo' => 'Automóviles',
                'campo1' => null,
            ],
            [
                'ramo' => 'Vida',
                'campo1' => null,
            ],
            // Agrega más ramos según sea necesario
        ]);
    }
}