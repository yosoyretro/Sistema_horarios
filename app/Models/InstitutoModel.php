<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutoModel extends Model
{
    use HasFactory;
    protected $table = 'instituto';
    protected $primaryKey = 'id_instituto';

    const CREATED_AT = "fecha_creacion";
    const UPDATE_AT = "fecha_actualizacion";
    

    protected $fillable = [
        'nombre',
        'codigo',
    ];
    
}
