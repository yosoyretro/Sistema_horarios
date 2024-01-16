<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaModel extends Model
{
    use HasFactory;
    protected $table = "materias";
    protected $primaryKey = "id_materia";
    
}
