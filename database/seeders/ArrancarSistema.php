<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\UsuarioModel;
use App\Models\PeriodoElectivoModel;
use App\Models\CarreraModel;
use App\Models\InstitutoModel;
use App\Models\RolModel;

class ArrancarSistema extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RolModel::create([
            "descripcion" => "Administrador",
            "ip_creacion" => "127.0.0.1",
            "ip_actualizacion" => "127.0.0.1",
            "id_usuario_creador" => 1,
            "id_usuario_actualizo" => 1,
            "fecha_creacion" => Carbon::now(),
            "fecha_actualizacion" => Carbon::now(),
            "estado" => "A"
        ]);

        /* Crear un usuario administrador
            UsuarioModel::create([
                "cedula" => "#########",
                "nombres" => "Admin Admin",
                "apellidos" => "Administrador Administrador",
                "usuario" => "Admin",
                "clave" => bcrypt("_Admin#2023*"),
                "id_rol" => 1,
                "ip_creacion" => "127.0.0.1",
                "ip_actualizacion" => "127.0.0.1",
                "id_usuario_creador" => 1,
                "id_usuario_actualizo" => 1,
                "fecha_creacion" => Carbon::now(),
                "fecha_actualizacion" => Carbon::now(),
                "estado" => "A"
            ]);*/

        // Crear otros datos necesarios para arrancar el sistema
        PeriodoElectivoModel::create([
            "inicia" => Carbon::now(),
            "termina" => Carbon::now(),
            "ip_creacion" => "127.0.0.1",
            "ip_actualizacion" => "127.0.0.1",
            "id_usuario_creador" => 1,
            "id_usuario_actualizo" => 1,
            "fecha_creacion" => Carbon::now(),
            "fecha_actualizacion" => Carbon::now(),
            "estado" => "A"
        ]);

        CarreraModel::create([
            "nombre" => "Desarrollo de software",
            "ip_creacion" => "127.0.0.1",
            "ip_actualizacion" => "127.0.0.1",
            "id_usuario_creador" => 1,
            "id_usuario_actualizo" => 1,
            "fecha_creacion" => Carbon::now(),
            "fecha_actualizacion" => Carbon::now(),
            "estado" => "A"
        ]);

        InstitutoModel::create([
            "nombre" => "Instituto Tecnológico de Guayaquil",
            "codigo" => "ISTG-124",
            "ubicacion" => "",
            "descripcion" => "",
            "nemonico" => "ISTG",
            "nivel_educacion" => "INSTITUTO",
            "jornada" => "NOCTURNA",
            "foto_educacion" => null,
            "ip_creacion" => "127.0.0.1",
            "ip_actualizacion" => "127.0.0.1",
            "id_usuario_creador" => 1,
            "id_usuario_actualizo" => 1,
            "fecha_creacion" => Carbon::now(),
            "fecha_actualizacion" => Carbon::now(),
            "estado" => "A"
        ]);
    }
}
