<?php

// database/migrations/2023_01_01_000025_create_ver_bienes_view.php

use Illuminate\Support\Facades\DB;

class CreateVerBienesView extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW ver_bienes AS
            SELECT b.id_bien, b.id_Caso, b.Objeto, b.Tipo, b.Caracteristicas, b.Fotos, b.Detalles, o.Descripcion, tb.tipo AS tipo_b,
                   (SELECT SUM(Valor_Cotizado) FROM valoraciones WHERE id_bien = b.id_bien) AS valor_cotizado,
                   (SELECT SUM(Valor_Aprobado) FROM valoraciones WHERE id_bien = b.id_bien) AS valor_Aprobado
            FROM bienes b
            LEFT JOIN objetos o ON o.id = b.Objeto
            LEFT JOIN tipo_bienes tb ON tb.id = b.Tipo
        ");
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS ver_bienes');
    }
}