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
        Schema::create('dimension_academica_cabecera', function (Blueprint $table) {
            $table->id('id_dimension_academica'); // Bigint primary key
            $table->unsignedBigInteger('id_distribucion_horario');
            $table->integer('punto_indice')->notNullable();
            $table->string('descripcion', 255)->notNullable();
            $table->string('ip_creacion', 45)->nullable();
            $table->string('ip_actualizacion', 45);
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo');
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion');
            $table->enum('estado', ['A', 'E', 'I'])->default('A'); 
            // Foreign key constraint
            $table->foreign('id_distribucion_horario')->references('id_distribucion')->on('distribuciones_horario_academica');
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
