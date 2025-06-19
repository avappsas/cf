<?php
// database/migrations/2023_01_01_000012_create_ciudades_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiudadesTable extends Migration
{
    public function up()
    {
        Schema::create('ciudades', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Provincia', 255)->nullable();
            $table->string('Ciudad', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ciudades');
    }
}