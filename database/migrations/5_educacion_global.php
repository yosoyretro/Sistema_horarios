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
        Schema::create('educacion_global', function (Blueprint $table) {
            $table->bigIncrements('id_educacion_global');
            $table->string('nombre')->nullable(false);
            $table->string('codigo')->nullable(false);
            $table->text('ubicacion')->nullable(false);
            $table->text('Descripcion')->nullable();
            $table->string('nemonico');
            $table->set('nivel_educacion',['PRIMARIA','SECUNDARIA','UNIVERSIDAD','INSTITUTO'])->nullable(false);
            $table->set('jornada',['MATUTINA','VESPERTINA','NOCTURNA'])->nullable(false);
            $table->binary('foto_educacion')->nullable(true);
            #CAMPOS DE AUDIFION
            $table->ipAddress('ip_creacion')->nullable(true);
            $table->ipAddress('ip_actualizacion');
            $table->integer("id_usuario_creador");
            $table->integer("id_usuario_actualizo");
            $table->date("fecha_creacion");
            $table->date("fecha_actualizacion");
            $table->set('estado', ['A', 'E', 'I'])->default('A');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educacion_global');
    }
};
