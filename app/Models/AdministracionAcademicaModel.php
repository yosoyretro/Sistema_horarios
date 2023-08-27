<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministracionAcademicaModel extends Model
{
    use HasFactory;
    protected $table = 'administracion_academica';
    protected $primaryKey = 'id_administracion_academica';

    protected $fillable = ['id_carrera','id_instituto'];
    
    public function carrera(){
        return $this->belongsTo(CarreraModel::class,'id_carrera');
    }

    public function insituto(){
        return $this->belongsTo(InstitutoModel::class,'id_instituto');
    }
}
