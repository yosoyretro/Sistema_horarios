<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajesModel extends Model
{
    use HasFactory;
    protected $table = "mensaje_alertas";
    protected $primaryKey = "id_mensaje_alertas";
    
    protected $fillable = [
        "codigo","mensaje","exception","estado"
    ];
}
