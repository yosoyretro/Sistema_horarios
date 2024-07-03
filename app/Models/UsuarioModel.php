<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UsuarioModel extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'cedula', 'nombres', 'apellidos', 'usuario', 'clave',
        'id_rol', 'ip_creacion', 'ip_actualizacion',
        'id_usuario_creador', 'id_usuario_actualizo', 'estado'
    ];

    public function titulosAcademicos()
    {
        return $this->hasMany(TituloAcademicoModel::class, 'id_usuario');
    }

}
