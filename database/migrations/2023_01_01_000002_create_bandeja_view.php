<?php

// database/migrations/2023_01_01_000002_create_bandeja_view.php

use Illuminate\Support\Facades\DB;

class CreateBandejaView extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW bandeja AS
            SELECT C.id, C.Reclamo_Aseguradora, C.No_Reporte, 
                   aa.Aseguradora AS Empresa_Aseguradora, 
                   u.name AS inspector
            FROM casos C
            LEFT JOIN aseguradoras aa ON C.Aseguradora = aa.id
            LEFT JOIN users u ON C.Inspector = u.id
            ORDER BY C.Fecha_Siniestro DESC
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS bandeja');
    }
}