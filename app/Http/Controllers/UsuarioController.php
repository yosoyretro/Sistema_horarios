<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use App\Http\Responses\TypeResponse;
use App\service\UsuarioServicio as ServiceUsuarioServicio;
use App\Services\UsuarioServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    private $servicio_usuario,$servicio_validaciones;
    public function __construct()
    {
        $this->servicio_usuario = new UsuarioServicio();
        $this->servicio_validaciones = new Validaciones();
    }

    public function createUsuario(Request $request)
    {
        $response = new TypeResponse();
        try{

            $servicio_usuario = $this->servicio_usuario->createuser($request->toArray());
            if(!$servicio_usuario["ok"])throw new Exception($servicio_usuario["msg_error"]);
            $response->setmensagge($servicio_usuario["msg"]); 
        }catch(Exception $e){
            
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getCode());
        }

        return json_encode($response->getdata());
    }

    public function showUsuario(){
        $response = new TypeResponse();
        try{

            $servicio_usuario = $this->servicio_usuario->getdatausuario(["tipo_consulta" => "4"]);
            
            if((empty($servicio_usuario["data"][0]))  ){
                $response->setmensagge("No hay registro de usuario");
                $response->setdata([]);
            }
	    $response->setdata($servicio_usuario["data"]);
        }catch(Exception $e){
            log::alert("SOY EL ERROR ");
            log::alert($e->getMessage());              
        }
        return json_encode($response->getdata());
    }

    public function deleteUsuario(request $request){
        $response = new TypeResponse();
        try{
            $response_usuario = $this->servicio_usuario->deleteUser($request->input('id_usuario'));
            if(!$response_usuario["ok"])throw new Exception($response_usuario["msg_error"]);
            $response->setmensagge($response_usuario["msg"]);
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getCode());
        }
        
        return json_encode($response->getdata()); 
    }

    public function editUser(request $request){
        $response = new TypeResponse();
        try{
            $servicio_usuario = $this->servicio_usuario->editUser($request->all());
            if(!$servicio_usuario["ok"])throw new Exception($servicio_usuario["msg_error"]);
            $response->setmensagge($servicio_usuario["msg"]); 
        }catch(Exception $e){
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getCode());
        }

        return json_encode($response->getdata());         
    }
}
