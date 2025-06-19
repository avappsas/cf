<?php

// database/migrations/2023_01_01_000001_create_casos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasosTable extends Migration
{
    public function up()
    {
        Schema::create('casos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_CFR', 255)->nullable();
            $table->integer('Aseguradora')->nullable();
            $table->integer('Ramo')->nullable();
            $table->integer('Broker')->nullable();
            $table->string('Reclamo_Aseguradora', 255)->nullable();
            $table->string('No_Reporte', 255)->nullable();
            $table->bigInteger('Asegurado')->nullable();
            $table->integer('Poliza_Anexo')->nullable();
            $table->string('Inicio_Poliza', 10)->nullable();
            $table->string('Fin_Poliza', 10)->nullable();
            $table->string('Fecha_Siniestro', 10)->nullable();
            $table->string('Fecha_Asignación', 10)->nullable();
            $table->string('Fecha_Reporte', 10)->nullable();
            $table->string('Lugar_Siniestro', 255)->nullable();
            $table->string('Sector_Evento', 255)->nullable();
            $table->string('Hora_Siniestro', 50)->nullable();
            $table->integer('Seguro_Afectado')->nullable();
            $table->text('Circunstancias')->nullable();
            $table->integer('Causa')->nullable();
            $table->text('Observaciones')->nullable();
            $table->string('Nombre', 255)->nullable();
            $table->integer('CI')->nullable();
            $table->string('Parentezo', 255)->nullable();
            $table->string('Ocupacion', 255)->nullable();
            $table->string('Telefonos', 255)->nullable();
            $table->string('Cobertura', 255)->nullable();
            $table->string('Compañía_de_Seguros', 255)->nullable();
            $table->integer('Inspector')->nullable();
            $table->string('Ejecutivo', 255)->nullable();
            $table->string('Valor_de_la_Reserva', 255)->nullable();
            $table->text('Requerimientos')->nullable();
            $table->string('Subrogación', 255)->nullable();
            $table->string('Salvamento', 255)->nullable();
            $table->string('Estado', 255)->nullable();
            $table->string('Ejecutivo2', 255)->nullable();
            $table->datetime('updated_at')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('Informe_Final')->nullable();
            $table->string('Facturacion', 255)->nullable();
            $table->string('Nombre_Asegurado', 100)->nullable();
            $table->string('Direccion_Asegurado', 255)->nullable();
            $table->string('Email_Asegurado', 100)->nullable();
            $table->integer('Id_Provincia')->nullable();

            // Claves foráneas
            $table->foreign('Aseguradora')->references('id')->on('aseguradoras');
            $table->foreign('Ramo')->references('id')->on('ramos');
            $table->foreign('Broker')->references('id')->on('brokers');
            $table->foreign('Causa')->references('Id')->on('causas');
            $table->foreign('Seguro_Afectado')->references('id')->on('seguros');
        });
    }

    public function down()
    {
        Schema::dropIfExists('casos');
    }
}