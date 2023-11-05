<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Http\Responses\TypeResponse;
use App\Models\MensajesModel;
use Exception;
class MensajeAlertasServicio{

    private $obj_mensajes_modelo;
    
    public function __construct()
    {
        $this->obj_mensajes_modelo = new MensajesModel();    
    }

    public function consultar($op,$array_asociativo)
    {
        $response = new TypeResponse();
        try{
            switch($op){
                case 1:
                    //consulta por el codig
                    $mensaje = $this->obj_mensajes_modelo::where("codigo","LIKE",$array_asociativo["codigo"])->get();
                    break;       
            }
            
            $response->setdata($mensaje);
        }catch(Exception $e){
            log::alert("SOY EL ERROR ");
            log::alert($e->getMessage());
            log::alert($e->getCode());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return $response->getdata();
    }
}

?>