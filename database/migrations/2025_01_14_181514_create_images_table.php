<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bien');
            $table->string('file_path'); // Ruta del archivo
            $table->string('description')->nullable(); // Descripción de la imagen
            $table->timestamps();

            // Llave foránea para relacionar con `bienes`
            $table->foreign('id_bien')->references('id_bien')->on('bienes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
