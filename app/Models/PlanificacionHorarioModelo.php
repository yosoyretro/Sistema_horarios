<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanificacionHorarioModelo extends Model
{
    use HasFactory;
    protected $table = 'planificacion_horarios';
    protected $primaryKey = 'id_planificacion_horarios';
    protected $fillable = ['id_asignatura','id_nivel','id_paralelo','id_dia','id_periodo_electivo','id_administracion_academica','id_usuario'];
    const CREATE_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
    
    public function asignatura(){
        return $this->belongsTo(AsignaturaModel::class,'id_asignatura');
    }

    public function nivel(){
        return $this->belongsTo(NivelModel::class,'id_nivel');   
    }

    public function paralelo(){
        return $this->belongsTo(ParaleloModel::class,'id_paralelo');
    }

    public function dia(){
        return $this->belongsTo(DiasModel::class,'id_dias');
    }

    public function periodoElectivo(){
        return $this->belongsTo(PeriodoElectivoModel::class,'id_periodo_electivo');
    }

    public function administracionAcademica(){
        return $this->belongsTo(AdministracionAcademicaModel::class,'id_administracion_academica');
    }

    public function usuario(){
        return $this->belongsTo(UsuarioModel::class,'id_usuario');
    }
}
