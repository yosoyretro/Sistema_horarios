<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('titulo_academico', function (Blueprint $table) {
            $table->id('id_titulo_academico'); // Bigint primary key
            $table->string('descripcion', 255);
            $table->string('ip_creacion', 45);
            $table->string('ip_actualizacion', 45)->nullable(true);
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo')->nullable(true);
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion')->nullable(true);
            $table->enum('estado', ['A', 'E', 'I'])->default('A');
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
