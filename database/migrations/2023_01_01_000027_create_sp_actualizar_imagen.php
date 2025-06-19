<?php
// database/migrations/2023_01_01_000027_create_sp_actualizar_imagen.php

use Illuminate\Support\Facades\DB;

class CreateSpActualizarImagen extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE PROCEDURE sp_ActualizarImagen(
                IN id_bien INT,
                IN ruta VARCHAR(250)
            )
            BEGIN
                INSERT INTO images (id_bien, file_path, created_at, updated_at)
                VALUES (id_bien, ruta, NOW(), NOW());
            END
        ");
    }

    public function down()
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_ActualizarImagen');
    }
}