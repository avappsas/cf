<?php

// database/migrations/2023_01_01_000008_create_tipo_bienes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoBienesTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_bienes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bien')->nullable();
            $table->string('tipo', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_bienes');
    }
}