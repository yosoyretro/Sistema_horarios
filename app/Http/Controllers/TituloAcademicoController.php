<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use App\Services\TituloAcademicoServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Support\Facades\Log;

class TituloAcademicoController extends Controller
{
    
    //VISTA DEL TITULO ACADEMICO
    private $validaciones_clase,$servicio_titulos_academico_clase;
    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->servicio_titulos_academico_clase = new TituloAcademicoServicio();
    }
    public function showTituloAcademico(Request $request){
        try{
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
            
            $validacion_titulo_academico = $this->validaciones_clase->validarRegistroForTituloAcademico(2,array_merge($datos,["tipo_validacion_existencia" => true]));
            if(!$validacion_titulo_academico["ok"])throw new Exception($validacion_titulo_academico["msg_error"]);
            $request_servicio = $this->servicio_titulos_academico_clase->CreateTitulo($datos);
            if(!$request_servicio["ok"])throw new Exception($request_servicio["msg_error"]) ;
            $response->setmensagge("Titutlo Academico Guardado con exito !");
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
            $response = new TypeResponse();
            // foreach($request->all() as $key => $values){
                
            //     if (!in_array($key,["id_titulo_academico","codigo","descripcion"]))throw new Exception("Los campos son requeridos");
            // }
            $validacion_titulo_academico = $this->validaciones_clase->validarRegistroForTituloAcademico(1,$request->all());
            if(!$validacion_titulo_academico["ok"])throw new Exception($validacion_titulo_academico["msg_error"]);
            if(!$validacion_titulo_academico["ok"] && !$validacion_titulo_academico["data"])throw new Exception($validacion_titulo_academico["exception"]);
    
            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->updateTituloAcademico($request);
            if(!$servicio_titulos_academico["ok"])throw new Exception($servicio_titulos_academico["msg_error"]);
            $response->setmensagge("Titulo actualizado con exito");
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
            $response = new TypeResponse();
            
            $validacion_titulo_academico = $this->validaciones_clase->validarRegistroForTituloAcademico(1,["id_titulo_academico"=>$request->input('id_titulo_academico')]);
            
            if(!$validacion_titulo_academico["ok"])throw new Exception($validacion_titulo_academico["msg_error"]);
            if(!$validacion_titulo_academico["ok"] && !$validacion_titulo_academico["data"])throw new Exception($validacion_titulo_academico["exception"]);

            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->deleteTituloAcademico($request->input('id_titulo_academico'));
            if(!$servicio_titulos_academico["ok"])throw new Exception($servicio_titulos_academico["msg_error"]);

            $response->setmensagge("Registro eliminado con exito");
        }catch(Exception $e){
            $response->setok(false);
            $response->setmensagge("A ocurrido un error en eliminar el titulo academico");
            $response->seterror($e->getMessage(),$e->getLine());
        }   
        
        return json_encode($response->getdata());
    }
}
