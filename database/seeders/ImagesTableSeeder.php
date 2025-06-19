<?php
// database/seeders/ImagesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('images')->insert([
            [
                'id_bien' => 1,
                'file_path' => 'images/foto1.jpg',
                'description' => 'Foto del daño',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más imágenes según sea necesario
        ]);
    }
}