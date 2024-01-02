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
        Schema::create('usuario',function (Blueprint $table){
            $table->bigIncrements('id_usuario');
            $table->string('cedula', 18)->unique();
            $table->string('nombres');
            $table->string('usuario', 150);
            $table->string('clave');
            $table->binary('imagen_perfil')->nullable();
            $table->unsignedBigInteger('id_rol');
            $table->json('id_titulo_academico');
            #CAMPOS DE AUDIFION
            $table->ipAddress('ip_creacion')->nullable(false);
            $table->set('estado',['A','E','I'])->default('A');
            $table->date('fecha_creacion')->default(now()->format('Y-m-d'));
            $table->time('hora_creacion')->default(now()->format('H:i:s'));
            $table->date('fecha_actualizacion')->nullable();
            $table->time('hora_actualizacion')->nullable();
            $table->ipAddress('ip_actualizacion')->nullable();
            $table->foreign('id_rol')->references('id_rol')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
