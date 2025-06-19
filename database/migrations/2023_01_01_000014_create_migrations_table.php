<?php

// database/migrations/2023_01_01_000014_create_migrations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMigrationsTable extends Migration
{
    public function up()
    {
        Schema::create('migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('migration', 255);
            $table->integer('batch');
        });
    }

    public function down()
    {
        Schema::dropIfExists('migrations');
    }
}