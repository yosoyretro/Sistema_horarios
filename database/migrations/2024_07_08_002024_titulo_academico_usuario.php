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
        Schema::create('titulo_academico_usuario', function (Blueprint $table) {
            $table->id('id_titulo_academico_usuario'); // Bigint primary key
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_titulo_academico');
            $table->string('ip_creacion', 45);
            $table->string('ip_actualizacion', 45)->nullable();
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo');
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion');
            $table->enum('estado', ['A', 'E', 'I'])->default('A');
            // Foreign key constraints
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_titulo_academico')->references('id_titulo_academico')->on('titulo_academico');
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
