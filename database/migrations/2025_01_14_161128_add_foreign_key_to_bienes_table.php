<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToBienesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->foreign('Objeto')->references('id')->on('objetos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->dropForeign(['Objeto']); // Elimina la clave foránea
        });
    }
}
