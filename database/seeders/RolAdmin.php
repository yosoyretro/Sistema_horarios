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
        DB::table('rol')->insert([
            [
                "descripcion" => "ADMINISTRADOR",
                "ip_creacion" => "192.168.14.13"
            ],
            [
                "descripcion" => "ESTUDIANTE",
                "ip_creacion" => "192.168.14.13"
            ],
            [
                "descripcion" => "DOCENTE",
                "ip_creacion" => "192.168.14.13"
            ],

        ]);
    }
}
