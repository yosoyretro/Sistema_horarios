<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribucionHorario extends Model
{
    use HasFactory;
    protected $table = "distribuciones_horario_academica";
    protected $primaryKey = "id_distribucion";
    
}
