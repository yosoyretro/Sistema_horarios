<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Services\InstitutoServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstitutoController extends Controller
{
    private $servicio_instituto_clase,$validaciones;

    public function __construct()
    {
        $this->servicio_instituto_clase = new InstitutoServicio();
        $this->validaciones = new Validaciones();

    }

    public function createInstituto(Request $request)
    {
        $response = new TypeResponse();
        try {
            $servicio_validar = $this->validaciones->validarRegistroForInstituto(2,[
                "codigo"=> $request->input('codigo'), 
                "nombre"=>$request->input('nombre'),
                "tipo_validacion_existencia" => true
            ]);

            if(!$servicio_validar["ok"])throw new Exception($servicio_validar["msg_error"]);
            
            $servicio_instituto = $this->servicio_instituto_clase->createInstituto(
                [
                    "codigo" => $request->input("codigo"),
                    "nombre" => $request->input("nombre")
                ]
            );
         
            if(!$servicio_instituto["ok"])throw new Exception($servicio_instituto["msg_error"]);
            $response->setmensagge("Instituto creado con exito");
        } catch (Exception $e) {

            log::alert("A ocurrido un error en la funcion de createInsituto\nLinea del error :". $e->getLine());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());

        }
        return json_encode($response->getdata());
    }

    public function UpdateInstituto(Request $request)
    {
        try{
            
            $response = new TypeResponse();
            
            $validacion_existencia = $this->validaciones->validarRegistroForInstituto(1,[
                "id_instituto" => $request->input("id_instituto"),
                "tipo_validacion_existencia" => false
            ]);
            if(!$validacion_existencia["ok"])throw new Exception($validacion_existencia["msg_error"]);

            $this->servicio_instituto_clase->UpdateInstituto([
                "id_instituto"=>$request->input("id_instituto"),
                "codigo"=>$request->input("codigo"),
                "nombre"=>$request->input("nombre")
            ]);
            
        }catch(Exception $e){
            log::alert("Error en la funcion UpdateInsituto controlador ");
            log::alert("Linea del error : " . $e->getLine());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }

        return json_encode($response->getdata());
    }

    public function deleteInstituto(Request $request)
    {
        $response = new TypeResponse();

        try{
            
            $servicio_validar = $this->validaciones->validarRegistroForInstituto(1,["id_instituto"=>$request->input('id_instituto'),"tipo_validacion_existencia"=>false]);
        
            if(!$servicio_validar["ok"])throw new Exception($servicio_validar["msg_error"]);

            $servicio_instituto = $this->servicio_instituto_clase->DeleteInstituto($request->input('id_instituto'));
            
            if(!$servicio_instituto["ok"])throw new Exception($servicio_instituto["msg_error"]);
            $response->setmensagge($servicio_instituto["msg"]);                
        }catch(Exception $e){
            log::alert("A ocurrido un eror en la funcion del delete Insituto : " . $e->getMessage() . "\nLinea del error :" . $e->getLine());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }
    
    public function showData()
    {
        $response = new TypeResponse();
        try{
            $servicio_instituto = $this->servicio_instituto_clase->Consultar(["tipo_consulta"=>4]);
            $response->setdata($servicio_instituto["data"]);
        }catch(Exception $e){

        }
        return json_encode($response->getdata());
    }
}
