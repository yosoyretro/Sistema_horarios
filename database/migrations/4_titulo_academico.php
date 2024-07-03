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
            $table->timestamp('fecha_creacion')->default(now());
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->ipAddress('ip_actualizacion')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();

            // Definir la clave foránea hacia la tabla 'usuarios'
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade'); // Eliminación en cascada si se elimina el usuario
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
