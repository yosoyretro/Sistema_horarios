<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TituloAcademicoModel extends Model
{
    use HasFactory;
    protected $table = 'titulo_academico';
    protected $primaryKey = 'id_titulo_academico';

    protected $fillable = ['codigo', 'descripcion', 'nemonico', 'ip_creacion', 'id_usuario', 'fecha_creacion', 'fecha_actualizacion'];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario');
    }
}
