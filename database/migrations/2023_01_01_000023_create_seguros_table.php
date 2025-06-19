<?php
// database/migrations/2023_01_01_000023_create_seguros_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegurosTable extends Migration
{
    public function up()
    {
        Schema::create('seguros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seguro', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seguros');
    }
}