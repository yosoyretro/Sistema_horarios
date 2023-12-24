<?php

namespace App\Http\Controllers;
use App\Http\Responses\TypeResponse;
use Exception;
use Illuminate\Http\Request;
use App\Services\RolServicio;

class RolController extends Controller
{
    protected $servicio_rol;
    public function __construct(){
        $this->servicio_rol = new RolServicio();
    }

    public function showRol(){
        $response = new TypeResponse();
        try{
            $roles = $this->servicio_rol->Consultar(["tipo_consulta"=>3]);
            if(!$roles["ok"])throw new Exception($roles["msg_error"]);
            $response->setdata($roles["data"]);
        }catch(Exception $e){
            $response->setok(false);
            $response->setmensagge($e->getMessage);
        }

        return json_encode($response->getdata());
    }

}
