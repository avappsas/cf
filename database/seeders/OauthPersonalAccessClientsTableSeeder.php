<?php
// database/seeders/OauthPersonalAccessClientsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthPersonalAccessClientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('oauth_personal_access_clients')->insert([
            [
                'client_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más clientes según sea necesario
        ]);
    }
}