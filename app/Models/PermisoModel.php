<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoModel extends Model
{
    use HasFactory;

    protected $table = 'permiso';
    protected $primaryKey = 'id_permiso';

    const CREATED_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
    
    protected $fillable = [
        'descripcion'
    ];
}
