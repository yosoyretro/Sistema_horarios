<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RolAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obj_request = new Request();
        DB::table('rol')->insert([[
                    "descripcion"=>"ADMINISTRADOR",
                    "ip_creacion"=>"192.168.14.13"
                ],
                [
                    "descripcion"=>"ESTUDIANTE",
                    "ip_creacion"=>"192.168.14.13"
                ],
                [
                    "descripcion"=>"DOCENTE",
                    "ip_creacion"=>"192.168.14.13"
                ],

            ]); 

        DB::table('paralelo')->insert([
                [
                    "numero_paralelo"=>"A",
                    "ip_creacion"=>"192.168.14.13"
                ],
                [
                    "numero_paralelo"=>"B",
                    "ip_creacion"=>"192.168.14.13"
                ],
                [
                    "numero_paralelo"=>"C",
                    "ip_creacion"=>"192.168.14.13"
                ],
                
            ]);

        DB::table('periodo_electivo')->insert([
                [
                    "inicia"=>"2024-01-01",
                    "termina"=>"2024-12-01",
                    "ip_creacion"=>"192.168.14.13"
                ]
            ]);

        DB::table('nivel')->insert([
                [
                    "numero"=>"1",
                    "nemonico"=>"1ERO",
                    "termino"=>"PRIMERO",
                    "ip_creacion"=>"192.168.14.13"
                ],
                [
                    "numero"=>"2",
                    "nemonico"=>"2DO",
                    "termino"=>"SEGUNDO",
                    "ip_creacion"=>"192.168.14.13"
                ],
                [
                    "numero"=>"3",
                    "nemonico"=>"3ERO",
                    "termino"=>"TERCERO",
                    "ip_creacion"=>"192.168.14.13"
                    
                ],

            ]);

        DB::table('dimension_academica')->insert([
                [
                    "punto_indice"=>"1",
                    "descripcion"=>"DOCENCIA",
                ],
                [
                    "punto_indice"=>"2",
                    "descripcion"=>"INVESTIGACIÓN",
                ],
                [
                    "punto_indice"=>"3",
                    "descripcion"=>"PRÁCTICAS PREPROFESIONALES",
                ],
                [
                    "punto_indice"=>"4",
                    "descripcion"=>"GESTIÓN ADMINISTRATIVA",
                ],
            ]);

        DB::table('educacion_global')->insert([
                [
                    "nombre"=>"INTITUTO DEL GUAYAQUIL",
                    "codigo"=>"ISTG-20212",
                    "ubicacion"=>"MACHALA Y GOMEZ RENDON    , GUAYAQUIL , ECUADOR",
                    "Descripcion"=>"",
                    "nemonico"=>"",
                    "nivel_educacion"=>"INSTITUCION",
                    "jornada"=>"NOCTURNA",

                ],
            ]);

    }
}
