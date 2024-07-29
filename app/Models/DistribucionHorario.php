<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribucionHorario extends Model
{
    use HasFactory;
    protected $table = "distribuciones_horario_academica";
    protected $primaryKey = "id_distribucion";
    protected $fillable = ["id_educacion_global","id_carrera","id_usuario","id_nivel","id_paralelo","id_periodo_electivo","id_materia","hora_inicio","hora_termina","dia","ip_creacion","ip_actualizacion","id_usuario_creador","id_usuario_actualizo","fecha_creacion","fecha_actualizacion","estado"];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    public function educacionGlobal(){
        return $this->belongsTo(InstitutoModel::class,"id_educacion_global", "id_instituto");
    }
    public function Carrera(){
        return $this->belongsTo(CarreraModel::class,"id_carrera","id_carrera");
    }
    public function Usuario(){
        return $this->belongsTo(UsuarioModel::class,"id_usuario","id_usuario");
    }
    public function Nivel(){
        return $this->belongsTo(NivelModel::class,"id_nivel","id_nivel");
    }
    public function Paralelo(){
        return $this->belongsTo(ParaleloModel::class,"id_paralelo","id_paralelo");
    }
    public function PeriodoAcademico(){
        return $this->belongsTo(PeriodoElectivoModel::class,"id_periodo_academico","id_periodo_electivo");
    }
    public function Materia(){
        return $this->belongsTo(AsignaturaModel::class,"id_materia","id_materia");
    }



}
