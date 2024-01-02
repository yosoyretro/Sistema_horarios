<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaModel extends Model
{
    use HasFactory;
    protected $table = 'materias';
    protected $primaryKey = 'id_materia';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['codigo','descripcion','ip_creacion','estado'];
    
}
