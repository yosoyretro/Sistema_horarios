<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutoModel extends Model
{
    use HasFactory;
    protected $table = 'instituto';
    protected $primaryKey = 'id_instituto';
    
    protected $fillable = ['codigo','nombre'];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
    //use HasFactory;
    // protected $table = 'asignatura';
    // protected $primaryKey = 'id_asignatura';
    // protected $fillable = ['descripcion','codigo'];
    // const CREATE_AT = 'fecha_creacion';
    // const UPDATE_AT = 'fecha_actualizacion';
    
    
}
