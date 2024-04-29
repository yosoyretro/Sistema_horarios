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
        Schema::create('planificacion_academica', function (Blueprint $table) {
            $table->bigIncrements('id_planificacion');
            $table->unsignedBigInteger('id_educacion_global');
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_nivel');
            $table->unsignedBigInteger('id_paralelo');
            $table->unsignedBigInteger('coordinador_carrera');
            $table->unsignedBigInteger('id_periodo_academico');
            #CAMPOS DE AUDIFION
            $table->ipAddress('ip_creacion')->nullable(true);
            $table->ipAddress('ip_actualizacion');
            $table->integer("id_usuario_creador");
            $table->integer("id_usuario_actualizo");
            $table->date("fecha_creacion");
            $table->date("fecha_actualizacion");
            $table->set('estado', ['A', 'E', 'I'])->default('A');
            //Relaciones
            $table->foreign('id_educacion_global')->references('id_educacion_global')->on('educacion_global');
            $table->foreign('id_carrera')->references('id_carrera')->on('carreras');
            $table->foreign('id_materia')->references('id_materia')->on('materias');
            $table->foreign('id_nivel')->references('id_nivel')->on('nivel');
            $table->foreign('id_paralelo')->references('id_paralelo')->on('paralelo');
            $table->foreign('id_periodo_academico')->references('id_periodo')->on('periodo_electivo');
            $table->foreign('coordinador_carrera')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planificacion_academica');
    }
};
