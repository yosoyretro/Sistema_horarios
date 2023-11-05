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
        schema::create("mensaje_alertas",function (Blueprint $table){
            $table->id('id_mensajes_alertas');
            $table->string('codigo');
            $table->string('mensaje');
            $table->string('excepcion');
            $table->string('estado',1);
        });
    }

    public function down(): void
    {
        schema::dropIfExists("mensaje_alertas");
    }
};
