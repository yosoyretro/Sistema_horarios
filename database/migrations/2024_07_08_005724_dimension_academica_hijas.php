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
        Schema::create('dimension_academica_hija', function (Blueprint $table) {
            $table->id('id_dimension_academica_hija'); // Bigint primary key
            $table->unsignedBigInteger('id_dimension_academica_cabecera');
            $table->integer('punto_indice')->notNullable();
            $table->string('descripcion', 255)->notNullable();
            $table->integer('hora')->notNullable();
            $table->string('ip_creacion', 45)->nullable();
            $table->string('ip_actualizacion', 45);
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo');
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion');
            $table->enum('estado', ['A', 'E', 'I'])->default('A');
            // Foreign key constraint
            $table->foreign('id_dimension_academica_cabecera')->references('id_dimension_academica')->on('dimension_academica_cabecera');
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
