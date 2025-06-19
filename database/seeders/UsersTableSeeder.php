<?php
// database/seeders/UsersTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'usuario' => 'admin',
                'activacion' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más usuarios según sea necesario
        ]);
    }
}