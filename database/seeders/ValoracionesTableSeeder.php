<?php
// database/seeders/ValoracionesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValoracionesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('valoraciones')->insert([
            [
                'id_bien' => 1,
                'descripcion' => 'Daño en el parachoques',
                'Cant' => 1,
                'Valor_Cotizado' => 500,
                'Valor_Aprobado' => 500,
                'updated_at' => now(),
            ],
            // Agrega más valoraciones según sea necesario
        ]);
    }
}