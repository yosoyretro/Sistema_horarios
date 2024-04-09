<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distribuciones_horario_academica', function (Blueprint $table) {
            $table->bigIncrements('id_distribucion');
            $table->unsignedBigInteger('id_educacion_global');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_nivel');
            $table->unsignedBigInteger('id_paralelo');
            $table->unsignedBigInteger('id_periodo_academico');
            $table->unsignedBigInteger('id_materia');
            $table->time('hora_inicio');
            $table->time('hora_termina');
            $table->enum('dia', ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO']);

            $table->foreign('id_educacion_global')->references('id_educacion_global')->on('educacion_global');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_carrera')->references('id_carrera')->on('carreras');
            $table->foreign('id_paralelo')->references('id_paralelo')->on('paralelo');
            $table->foreign('id_nivel')->references('id_nivel')->on('nivel');
            $table->foreign('id_materia')->references('id_materia')->on('materias');
            $table->foreign('id_periodo_academico')->references('id_periodo')->on('periodo_electivo');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('distribuciones_horario_academica');
    }
};
