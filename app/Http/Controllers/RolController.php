<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use Exception;
use Illuminate\Http\Request;
use App\Services\RolServicio;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    protected $servicio_rol;
    public function __construct()
    {
        $this->servicio_rol = new RolServicio();
    }

    public function showRol()
    {
        $response = new TypeResponse();
        try {
            $roles = $this->servicio_rol->Consultar(["tipo_consulta" => 3]);
            log::alert("SOy el de roles");
            log::alert(collect($roles));
            if (!$roles["ok"]) throw new Exception($roles["msg_error"]);
            $response->setdata($roles["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge($e->getMessage());
        }

        return json_encode($response->getdata());
    }


    public function createRol(Request $request)
    {
        $response = new TypeResponse();
        try {

        } catch (Exception $e) {
            
        }
    }

    public function updateRol(Request $request)
    {
        $response = new TypeResponse();
        try {

        } catch (Exception $e) {
            
        }
    }
}
