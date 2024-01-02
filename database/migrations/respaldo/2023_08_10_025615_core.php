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
        Schema::create('instituto', function (Blueprint $table) {
            $table->bigIncrements('id_instituto');
            $table->string('nombre');
            $table->string('codigo');
            $table->string('estado', 2)->default('A');
            $table->timestamp('fecha_creacion')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('fecha_actualizacion')->useCurrent();
        });

        Schema::create('carrera', function (Blueprint $table) {
            $table->bigIncrements('id_carrera');
            $table->string('nombre');
            $table->string('codigo');
            //CAMPOS OBLIGATIORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('administracion_academica', function (Blueprint $table) {
            $table->bigIncrements('id_administracion_academica');
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_instituto');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
            //RELACIONES
            $table->foreign('id_carrera')->references('id_carrera')->on('carrera');
            $table->foreign('id_instituto')->references('id_instituto')->on('instituto');
        });


        Schema::create('periodo_electivo', function (Blueprint $table) {
            $table->bigIncrements('id_periodo_electivo');
            $table->date('fecha_inicio');
            $table->date('fecha_termina');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });


        Schema::create('asignatura', function (Blueprint $table) {
            $table->bigIncrements('id_asignatura');
            $table->string('descripcion');
            $table->string('codigo');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });


        Schema::create('nivel', function (Blueprint $table) {
            $table->bigIncrements('id_nivel');
            $table->integer('numero');
            $table->string('descripcion');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });


        Schema::create('paralelo', function (Blueprint $table) {
            $table->bigIncrements('id_paralelo');
            $table->string('paralelo', 1);
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });



        // Schema::create('dias', function (Blueprint $table) {
        //     $table->bigIncrements('id_dias');
        //     $table->string('dia');
        //     //CAMPOS OBLIGATORIOS
        //     $table->string('estado', 2)->default('A');
        //     $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
        //     $table->timestamp('updated_at')->useCurrent();
        // });


        Schema::create('rol', function (Blueprint $table) {
            $table->bigIncrements('id_rol');
            $table->string('descripcion');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('permiso', function (Blueprint $table) {
            $table->bigIncrements('id_permiso');
            $table->string('descripcion');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('control_permisos', function (Blueprint $table) {
            $table->bigIncrements('id_control_permisos');
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_permiso');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
            //RELACIONES
            $table->foreign('id_rol')->references('id_rol')->on('rol');
            $table->foreign('id_permiso')->references('id_permiso')->on('permiso');
        });


        Schema::create('titulo_academico', function (Blueprint $table) {
            $table->bigIncrements('id_titulo_academico');
            $table->string('descripcion');
            $table->string('codigo');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('fecha_creacion')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('fecha_actualizacion')->useCurrent();
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->bigIncrements('id_usuario');
            $table->string('cedula', 18);
            $table->string('nombres');
            $table->string('usuario', 150);
            $table->string('clave', 50);
            $table->unsignedBigInteger('id_rol');
            $table->json('id_titulo_academico');
            //CAMPOS OBLIGATORIOS
            $table->string('estado', 2)->default('A');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent();
            // $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            // $table->timestamp('updated_at')->useCurrent();
            //RELACIONES
            $table->foreign('id_rol')->references('id_rol')->on('rol');
        });

        Schema::create('planificacion_horarios', function (Blueprint $table) {
            $table->bigIncrements('id_planificacion_horarios');
            $table->unsignedBigInteger('id_asignatura');
            $table->unsignedBigInteger('id_nivel');
            $table->unsignedBigInteger('id_paralelo');
            $table->unsignedBigInteger('id_dia');
            $table->unsignedBigInteger('id_periodo_electivo');
            $table->unsignedBigInteger('id_administracion_academica');
            $table->time('inicia');
            $table->time('termina');
            //CAMPOS OBLIGATORIO
            $table->string('estado', 2)->default('A');
            $table->timestamp('created_at')->useCurrent(); // Nombre corregido a 'created_at'
            $table->timestamp('updated_at')->useCurrent();
            //RELACIONES
            $table->foreign('id_asignatura')->references('id_asignatura')->on('asignatura');
            $table->foreign('id_nivel')->references('id_nivel')->on('nivel');
            $table->foreign('id_paralelo')->references('id_paralelo')->on('paralelo');
            $table->foreign('id_dia')->references('id_dias')->on('dias');
            $table->foreign('id_periodo_electivo')->references('id_periodo_electivo')->on('periodo_electivo');
            $table->foreign('id_administracion_academica')->references('id_administracion_academica')->on('administracion_academica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('insituto');
        Schema::dropIfExists('carrera');
        Schema::dropIfExists('administracion_academica');
        Schema::dropIfExists('periodo_electivo');
        Schema::dropIfExists('asignatura');
        Schema::dropIfExists('nivel');
        Schema::dropIfExists('paralelo');
        Schema::dropIfExists('dias');
        Schema::dropIfExists('rol');
        Schema::dropIfExists('permiso');
        Schema::dropIfExists('control_permisos');
        Schema::dropIfExists('titulo_academico');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('planificacion_horarios');
    }
};
