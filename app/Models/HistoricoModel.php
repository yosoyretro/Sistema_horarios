<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoModel extends Model
{
    use HasFactory;

    protected $table = 'historicos_eliminaciones';
    protected $primaryKey = 'id_historico_eliminaciones';
    const CREATED_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
}
