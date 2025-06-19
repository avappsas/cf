<?php // database/seeders/CasosTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CasosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('casos')->insert([
            [
                'id_CFR' => 'CFR001',
                'Aseguradora' => 1,
                'Ramo' => 1,
                'Broker' => 1,
                'Reclamo_Aseguradora' => 'Reclamo 001',
                'No_Reporte' => 'Reporte 001',
                'Asegurado' => 123456789,
                'Poliza_Anexo' => 1,
                'Inicio_Poliza' => '2023-01-01',
                'Fin_Poliza' => '2023-12-31',
                'Fecha_Siniestro' => '2023-06-15',
                'Fecha_Asignación' => '2023-06-16',
                'Fecha_Reporte' => '2023-06-17',
                'Lugar_Siniestro' => 'Ciudad Uno',
                'Sector_Evento' => 'Zona Norte',
                'Hora_Siniestro' => '10:00',
                'Seguro_Afectado' => 1,
                'Circunstancias' => 'Accidente de tránsito',
                'Causa' => 1,
                'Observaciones' => 'Ninguna',
                'Nombre' => 'Juan Pérez',
                'CI' => 12345678,
                'Parentezo' => 'Conductor',
                'Ocupacion' => 'Ingeniero',
                'Telefonos' => '123456789',
                'Cobertura' => 'Completa',
                'Compañía_de_Seguros' => 'Seguros XYZ',
                'Inspector' => 1,
                'Ejecutivo' => 'Ejecutivo Uno',
                'Valor_de_la_Reserva' => '10000',
                'Requerimientos' => 'Ninguno',
                'Subrogación' => 'No',
                'Salvamento' => 'No',
                'Estado' => 'Abierto',
                'Ejecutivo2' => 'Ejecutivo Dos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más casos según sea necesario
        ]);
    }
}