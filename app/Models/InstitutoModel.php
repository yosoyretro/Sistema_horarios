<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutoModel extends Model
{
    use HasFactory;
    protected $table = 'instituto';
    protected $primaryKey = 'id_instituto';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'codigo',
        'nombre',
        'estado',
        'fecha_creacion',
        'fecha_actualizacion'
    ];
    
}
