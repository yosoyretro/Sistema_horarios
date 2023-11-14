<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoElectivoModel extends Model
{
    use HasFactory;
    protected $table = 'periodo_electivo';
    protected $primaryKey = 'id_periodo_electivo';
    protected $fillable = ['fecha_inicio','fecha_termina'];
    const CREATE_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
}
