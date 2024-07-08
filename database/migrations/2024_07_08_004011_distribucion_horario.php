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
            $table->id('id_distribucion'); // Bigint primary key
            $table->unsignedBigInteger('id_educacion_global');
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_nivel');
            $table->unsignedBigInteger('id_paralelo');
            $table->unsignedBigInteger('id_periodo_academico');
            $table->unsignedBigInteger('id_materia');
            $table->time('hora_inicio');
            $table->time('hora_termina');
            $table->enum('dia', ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO']);
            $table->string('ip_creacion', 45)->nullable();
            $table->string('ip_actualizacion', 45);
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo');
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion');
            $table->enum('estado', ['A', 'E', 'I'])->default('A');
            // Foreign key constraints
            $table->foreign('id_educacion_global')->references('id_educacion_global')->on('educacion_global');
            $table->foreign('id_carrera')->references('id_carrera')->on('carreras');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_nivel')->references('id_nivel')->on('nivel');
            $table->foreign('id_paralelo')->references('id_paralelo')->on('paralelo');
            $table->foreign('id_periodo_academico')->references('id_periodo')->on('periodo_electivo');
            $table->foreign('id_materia')->references('id_materia')->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
