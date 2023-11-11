<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    use HasFactory;
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    const CREATED_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
    
    protected $fillable = [
        'cedula','nombres','usuario','clave','id_rol','id_titulo_academico'
    ];
    
    public function rol(){
        return $this->belongsTo(RolModel::class,'id_rol');
    }

    public function tituloAcademico(){
        return $this->belongsTo(TituloAcademicoModel::class,'id_titutlo_academico');
    }

}
