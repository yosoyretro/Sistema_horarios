<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarreraModel extends Model
{
    use HasFactory;
    protected $table = "carrera";
    protected $primaryKey = "id_carrera";
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';

    
    protected $fillable = [
        'nombre',
        'codigo',
    ];


}
