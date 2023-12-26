<?php

namespace App\Http\Controllers;

use App\Services\UsuarioServicio;
use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use App\Services\TituloAcademicoServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Support\Facades\Log;

class TituloAcademicoController extends Controller
{
    
    //VISTA DEL TITULO ACADEMICO
    private $validaciones_clase,$servicio_titulos_academico_clase,$servicio_usuarios;
    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->servicio_usuario = new UsuarioServicio();
        $this->servicio_titulos_academico_clase = new TituloAcademicoServicio();
    }
    public function showTituloAcademico(Request $request){
        try{
            log::alert("sOY EL SHOW TITULO ACADEMICO ");
            $response = new TypeResponse();
            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->consultarTitulo(6);
            $response->setdata($servicio_titulos_academico["data"]);
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }
    // Crear TITULO ACADEMICO
    public function createTituloAcademico(Request $request){
        
        try{
            $response = new TypeResponse();
            $datos = [
                'descripcion' => $request->input('descripcion'),
                'codigo' => $request->input('codigo')
            ];
            
            $request_servicio = $this->servicio_titulos_academico_clase->CreateTitulo($datos);
            if(!$request_servicio["ok"])throw new Exception($request_servicio["msg_error"]) ;
            $response->setmensagge("El titulo de ".strtoupper($request->input('descripcion'))." se creo con exito ");
        }catch(Exception $e){
            log::alert("Funcion de createTituloAcademico");
            log::alert("Linea del error :" . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(),$e);
        }

        return json_decode($response->getdata());
    }  

    // ACTUALIZAR TITULO ACADEMICO
    public function updateTituloAcademico(Request $request){    
        try{
            log::alert("Soy el request");
            log::alert(collect($request->all()));
            $response = new TypeResponse();

            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->updateTituloAcademico($request->all());
            if(!$servicio_titulos_academico["ok"])throw new Exception($servicio_titulos_academico["msg_error"]);
            $response->setmensagge("Titulo actualizado con exito , verifique la informacion");
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }
    
    // //ELIMINAR TITULO ACADEMICO
    public function deleteTituloAcademico(Request $request)
    {
        try{
            log::alert("SOy el request");
            log::alert($request);
            $response = new TypeResponse();
            $response_usuario = $this->servicio_usuario->getdatausuario(["tipo_consulta"=>4]);

            $info = $response_usuario["data"];
            $info->map(function($dato) use ($request){
                $info_validador = collect($dato["id_titulo_academico"])->where("id_titulo_academico",$request->input("id_titulo_academico"));
                
                if(count($dato["id_titulo_academico"]) == 1 && $info_validador){                  
                    
                    if(!$request_usuario = $this->servicio_usuario->deleteUser($dato->id_usuario)["ok"])throw new Exception($request_usuario["msg"]);
                }else if(count($dato["id_titulo_academico"]) > 1 && $info_validador){
                    $arreglo_titulos = [];
                    foreach ($dato["id_titulo_academico"] as $value) {
                        if($request->input("id_titulo_academico") != $value->id_titulo_academico){
                            array_push($arreglo_titulos,$value->id_titulo_academico);
                        }else{
                            $descripcion = $value->descripcion; 
                        }
                    }
                    $this->servicio_usuario->editUser(["id_usuario"=>$dato->id_usuario,"cedula"=>$dato->cedula,"nombres"=>$dato->nombres,"usuario"=>$dato->usuario,"id_rol"=>$dato->id_rol->id_rol,"id_titulo_academico"=>$arreglo_titulos]);
                }

            });

            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->deleteTituloAcademico($request->input('id_titulo_academico'));

            if(!$servicio_titulos_academico["ok"])throw new Exception($servicio_titulos_academico["msg_error"]);

            $response->setmensagge("El titulo se elimino con exito , verifique la informacion");
        }catch(Exception $e){
            log::alert("Mensaje :" . $e->getMessage());
            log::alert("Linea :" . $e->getLine());
            $response->setok(false);
            $response->setmensagge("A ocurrido un error en eliminar el titulo academico");
            $response->seterror($e->getMessage(),$e->getLine());
        }   
        
        return json_encode($response->getdata());
    }
}
