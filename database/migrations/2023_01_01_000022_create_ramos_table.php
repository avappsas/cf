<?php
// database/migrations/2023_01_01_000022_create_ramos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRamosTable extends Migration
{
    public function up()
    {
        Schema::create('ramos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ramo', 255)->nullable();
            $table->string('campo1', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ramos');
    }
}