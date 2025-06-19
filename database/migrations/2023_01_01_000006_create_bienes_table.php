<?php

// database/migrations/2023_01_01_000006_create_bienes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienesTable extends Migration
{
    public function up()
    {
        Schema::create('bienes', function (Blueprint $table) {
            $table->increments('id_bien');
            $table->integer('id_Caso')->nullable();
            $table->string('Bien_Asegurado', 150)->nullable();
            $table->integer('Objeto')->nullable();
            $table->integer('Tipo')->nullable();
            $table->text('Caracteristicas')->nullable();
            $table->text('Fotos')->nullable();
            $table->text('Detalles')->nullable();
            $table->integer('objeto_id')->nullable();

            // Claves foráneas
            $table->foreign('Objeto')->references('id')->on('objetos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bienes');
    }
}