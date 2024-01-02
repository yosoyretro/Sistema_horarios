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
        Schema::create('titulo_academico', function (Blueprint $table) {
            $table->bigIncrements('id_titulo_academico');
            $table->string('codigo')->nullable(false)->unique();
            $table->string('nemonico')->nullable(false)->unique();
            $table->string('descripcion')->nullable(false);
            #CAMPOS DE AUDICION
            $table->ipAddress('ip_creacion')->nullable(false);
            $table->set('estado',['A','E','I'])->default('A');
            $table->date('fecha_creacion')->default(now()->format('Y-m-d'));
            $table->time('hora_creacion')->default(now()->format('H:i:s'));
            $table->date('fecha_actualizacion')->nullable();
            $table->time('hora_actualizacion')->nullable();
            $table->ipAddress('ip_actualizacion')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulo_academico');
    }
};
