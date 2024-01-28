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
        Schema::create('resumen_horas', function (Blueprint $table) {
            $table->bigIncrements('id_resumen');
            $table->string('hora');
            $table->string('descripcion');
            $table->unsignedBigInteger('id_distribucion_horario');
            $table->unsignedBigInteger('id_dimension_academica');
            #CAMPOS DE AUDIFION
            $table->ipAddress('ip_creacion')->nullable(true);
            $table->set('estado', ['A', 'E', 'I'])->default('A');
            $table->date('fecha_creacion')->default(now()->format('Y-m-d'));
            $table->time('hora_creacion')->default(now()->format('H:i:s'));
            $table->date('fecha_actualizacion')->nullable();
            $table->time('hora_actualizacion')->nullable();
            $table->ipAddress('ip_actualizacion');
            $table->foreign('id_distribucion_horario')->references('id_distribucion')->on('distribuciones_horario_academica');
            $table->foreign('id_dimension_academica')->references('id_dimension_academica')->on('dimension_academica'); 
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumen_horas');
    }
};
