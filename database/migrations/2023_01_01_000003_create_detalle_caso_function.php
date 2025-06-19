<?php

// database/migrations/2023_01_01_000003_create_detalle_caso_function.php

use Illuminate\Support\Facades\DB;

class CreateDetalleCasoFunction extends Migration
{
    public function up()
    {
        DB::statement('
            CREATE FUNCTION Detalle_Caso(id_caso INT) 
            RETURNS JSON
            BEGIN
                RETURN (
                    SELECT JSON_OBJECT(
                        -- Estructura JSON equivalente
                    )
                );
            END
        ');
    }

    public function down()
    {
        DB::statement('DROP FUNCTION IF EXISTS Detalle_Caso');
    }
}