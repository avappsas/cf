<?php
// database/migrations/2023_01_01_000007_create_objetos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetosTable extends Migration
{
    public function up()
    {
        Schema::create('objetos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ramo')->nullable();
            $table->string('Descripcion', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('objetos');
    }
}