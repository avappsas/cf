<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('email_verified_at', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('created_at', 255)->nullable();
            $table->string('updated_at', 255)->nullable();
            $table->string('usuario', 255);
            $table->integer('activacion')->nullable();
            $table->string('api_token', 150)->nullable();
            $table->string('fotoPerfil', 1500)->nullable();
            $table->string('telefonos', 50)->nullable();
            $table->integer('ciudad')->nullable();
            $table->integer('Id_provincia')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}