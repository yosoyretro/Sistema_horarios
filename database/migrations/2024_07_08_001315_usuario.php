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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // Bigint primary key
            $table->string('cedula', 18)->unique();
            $table->string('nombres', 255);
            $table->string('apellidos', 255);
            $table->string('usuario', 150);
            $table->string('clave', 255);
            $table->binary('imagen_perfil')->nullable();
            $table->unsignedBigInteger('id_rol');
            $table->string('ip_creacion', 45)->nullable();
            $table->string('ip_actualizacion', 45);
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo');
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion');
            $table->enum('estado', ['A', 'E', 'I'])->default('A');

            // Foreign key constraint
            $table->foreign('id_rol')->references('id_rol')->on('rol');
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
