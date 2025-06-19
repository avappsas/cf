<?php

// database/migrations/2023_01_01_000010_create_brokers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrokersTable extends Migration
{
    public function up()
    {
        Schema::create('brokers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Broker', 255)->nullable();
            $table->string('campo1', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brokers');
    }
}