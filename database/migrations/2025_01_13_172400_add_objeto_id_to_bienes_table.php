<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjetoIdToBienesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->foreignId('objeto_id')->constrained()->onDelete('cascade');  // Crea la columna de clave foránea
        });
    }
    
    public function down()
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->dropForeign(['objeto_id']);
            $table->dropColumn('objeto_id');
        });
    }
}
