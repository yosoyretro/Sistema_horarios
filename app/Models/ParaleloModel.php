<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParaleloModel extends Model
{
    use HasFactory;
    protected $table = 'paralelo';
    protected $primaryKey = 'id_paralelo';
    protected $fillable = ['paralelo'];
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

}
