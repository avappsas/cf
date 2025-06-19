<?php
// database/seeders/WebsocketsStatisticsEntriesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsocketsStatisticsEntriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('websockets_statistics_entries')->insert([
            [
                'app_id' => 'app1',
                'peak_connection_count' => 10,
                'websocket_message_count' => 100,
                'api_message_count' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más entradas según sea necesario
        ]);
    }
}