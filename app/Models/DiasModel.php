<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasModel extends Model
{
    use HasFactory;
    protected $table = 'dias';
    protected $primaryKey = 'id_dias';
    protected $fillable = ['dia'];
    const CREATE_AT = 'fecha_creacion';
    const UPDATE_AT = 'fecha_actualizacion';
    
}
