<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContolPermisoModel extends Model
{
    use HasFactory;
    protected $table = 'control_permisos';
    protected $primaryKey = 'id_control_permisos';

    const CREATED_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id_rol','id_permiso'
    ];
    
    public function rol(){
        return $this->belongsTo(RolModel::class,'id_rol');
    }

    public function permiso(){
        return $this->belongsTo(PermisoModel::class,'id_permiso');
    }
    
}
