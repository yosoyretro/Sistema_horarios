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
        Schema::create('materias', function (Blueprint $table) {
            $table->bigIncrements('id_materia');
            $table->string('descripcion')->nullable(false)->unique(true);
            #CAMPOS DE AUDICION
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
        Schema::dropIfExists('materias');
    }
};
