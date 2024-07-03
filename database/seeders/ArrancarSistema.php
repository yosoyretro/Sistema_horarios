<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Carrera;
use App\Models\CarreraModel;
use App\Models\EducacionGlobal;
use App\Models\InstitutoModel;
use App\Models\PeriodoElectivoModel;
use App\Models\RolModel;
use App\Models\UsuarioModel;
use Carbon\CarbonConverterInterface;

class ArrancarSistema extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        RolModel::created([
            "descripcion" => "Administrador",
            "ip_creacion" => "127.0.0.1",
            "ip_actualizacion" => "127.0.0.1",
            "id_usuario_creador" => 1,
            "id_usuario_actualizo" => 1,
            "fecha_creacion" => Carbon::now(),
            "fecha_actualizacion" => Carbon::now(),
            "estado" => "A"
        ]);
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
        ]);
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
            "nombre" => "Instituto tecnologico de Guayaquil",
            "codigo" => "ISTG-124",
            "ubicacion" => "",
            "Descripcion" => "",
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
