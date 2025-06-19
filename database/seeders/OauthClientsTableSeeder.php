<?php
// database/seeders/OauthClientsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('oauth_clients')->insert([
            [
                'user_id' => null,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'secret',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más clientes según sea necesario
        ]);
    }
}