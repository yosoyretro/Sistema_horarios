<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenHoraModel extends Model
{
    use HasFactory;
    protected $table = "resumen_horas";
    protected $primaryKey = "id_resumen";
}
