<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaModel extends Model
{
    use HasFactory;
    protected $table = 'asignatura';
    protected $primaryKey = 'id_asignatura';
    protected $fillable = ['descripcion','codigo'];
    const CREATE_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
    
}
