<?php
// database/migrations/2023_01_01_000011_create_causas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCausasTable extends Migration
{
    public function up()
    {
        Schema::create('causas', function (Blueprint $table) {
            $table->increments('Id');
            $table->integer('id_ramo')->nullable();
            $table->string('Causa', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('causas');
    }
}