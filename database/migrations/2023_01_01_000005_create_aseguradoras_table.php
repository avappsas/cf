<?php
// database/migrations/2023_01_01_000005_create_aseguradoras_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAseguradorasTable extends Migration
{
    public function up()
    {
        Schema::create('aseguradoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Aseguradora', 255)->nullable();
            $table->integer('id_Ramo')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aseguradoras');
    }
}