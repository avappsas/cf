<?php

// database/seeders/BrokersTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrokersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('brokers')->insert([
            [
                'Broker' => 'Broker Uno',
                'campo1' => null,
            ],
            [
                'Broker' => 'Broker Dos',
                'campo1' => null,
            ],
            // Agrega más brokers según sea necesario
        ]);
    }
}