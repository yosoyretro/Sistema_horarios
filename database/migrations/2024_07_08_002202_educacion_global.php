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
            $table->id('id_educacion_global'); // Bigint primary key
            $table->string('nombre', 255)->notNullable();
            $table->string('codigo', 255)->notNullable();
            $table->text('ubicacion')->notNullable();
            $table->text('descripcion')->nullable();
            $table->string('nemonico', 255)->nullable();
            $table->enum('nivel_educacion', ['PRIMARIA', 'SECUNDARIA', 'UNIVERSIDAD', 'INSTITUTO'])->notNullable();
            $table->enum('jornada', ['MATUTINA', 'VESPERTINA', 'NOCTURNA'])->notNullable();
            $table->binary('foto_educacion')->nullable();
            $table->string('ip_creacion', 45)->nullable();
            $table->string('ip_actualizacion', 45);
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_actualizo');
            $table->date('fecha_creacion');
            $table->date('fecha_actualizacion');
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
