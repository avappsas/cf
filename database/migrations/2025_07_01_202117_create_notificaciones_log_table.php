<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('notificaciones_log', function (Blueprint $table) {
        $table->id();
        $table->string('tipo'); // contrato, cuota, general
        $table->string('destinatario'); // nombre o área
        $table->string('telefono')->nullable();
        $table->string('correo')->nullable();
        $table->text('mensaje');
        $table->string('canal'); // whatsapp, mail, ambos
        $table->unsignedBigInteger('contrato_id')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones_log');
    }
}
