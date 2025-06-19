<?php

// database/migrations/2023_01_01_000009_create_valoraciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValoracionesTable extends Migration
{
    public function up()
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bien')->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->integer('Cant')->nullable();
            $table->integer('Valor_Cotizado')->nullable();
            $table->integer('Valor_Aprobado')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('valoraciones');
    }
}