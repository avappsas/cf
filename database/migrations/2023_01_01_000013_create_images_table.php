<?php

// database/migrations/2023_01_01_000013_create_images_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bien');
            $table->string('file_path', 255);
            $table->string('description', 255)->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();

            // Clave foránea
            $table->foreign('id_bien')->references('id_bien')->on('bienes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}