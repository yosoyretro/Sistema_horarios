<?php

namespace Database\Seeders;


use Illuminate\Http\Request;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $obj_request = new Request();
        DB::table('usuario')->insert([
            'cedula'=>'0',
            'nombres'=>'carlos javier Moreno Alcivar',
            'usuario'=>'administrador@admin.com',
            'clave'=>bcrypt('$horarios#2023*'),
            'id_rol'=>1,
            'id_titulo_academico'=>json_encode([]),
            'ip_creacion'=>"192.168.14.13"
        ]);

    }
}
