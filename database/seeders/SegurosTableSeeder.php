<?php // database/seeders/SegurosTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegurosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('seguros')->insert([
            [
                'seguro' => 'Seguro de Auto',
            ],
            [
                'seguro' => 'Seguro de Vida',
            ],
            // Agrega más seguros según sea necesario
        ]);
    }
}