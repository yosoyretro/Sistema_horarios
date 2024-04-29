<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanificacionAcademicaModel extends Model
{
    use HasFactory;
    protected $table = 'planificacion_academica';
    protected $primaryKey = 'id_planificacion';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
}
