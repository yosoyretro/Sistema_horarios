<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class MensajeAlertasServicio
{
    private $ip;
    private $usuario;
    private $fecha_hora;
    public function __construct()
    {
        $obj_carbon = new Carbon();//LIBRERIA PARA LAS FECHAS
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->fecha_hora = $obj_carbon->format("m-d-Y");
    }
    
    public function storeInformativoLogs($archivo,$funcion)
    {
        try{
            log::info("+--------------Informativo de usabilidad--------------------+");
            log::info("FECHA Y HORA : " . $this->fecha_hora);
            log::info("IP : " . $this->ip);
            log::info("ARCHIVO : " .  $archivo);
            log::info("FUNCION : " . $funcion);
            log::info("+-----------------------------------------------------------+");
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}

?>