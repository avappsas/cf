<?php

// database/migrations/2023_01_01_000021_create_provincias_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinciasTable extends Migration
{
    public function up()
    {
        Schema::create('provincias', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Provincia', 255)->nullable();
            $table->string('Pais', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('provincias');
    }
}