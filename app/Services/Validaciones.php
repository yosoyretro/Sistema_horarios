<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use Exception;
use Illuminate\Support\Facades\Log;

class Validaciones
{


    public function validarRegistroForTituloAcademico($opcion, $array_asociativo)
    {
        try {
            log::alert("ARRAY");
            log::alert($array_asociativo);
            $response = new TypeResponse();
            $servicio_titulo_academico = new TituloAcademicoServicio();

            if (!is_array($array_asociativo)) throw new Exception("El dato debe de ser un array asociativo");
            switch ($opcion) {
                case 1:
                    //validar registro por el id
                    if (!$array_asociativo["id_titulo_academico"]) throw new Exception("Error la clave del id_titulo_academico no existe");
                    if (!is_numeric($array_asociativo["id_titulo_academico"])) throw new Exception("El dato no debe de ser string");
                    $response_titulo_academico = $servicio_titulo_academico->consultarTitulo(1, $array_asociativo);
                    
                    break;
                case 2:
                    //validar por codigo o por descripcion
                    if(!isset($array_asociativo["descripcion"]) || !isset($array_asociativo["codigo"]))throw new Exception("Debe de envviar correctamente los datos");
                    $response_titulo_academico = $servicio_titulo_academico->consultarTitulo(5,[
                        "codigo"=>$array_asociativo["codigo"],
                        "descripcion"=>$array_asociativo["descripcion"],
                    ]);
                    break;
                // case 2:
                //     //validar el registro por el codigo 
                // case 3:
                //     //validar el registro por la descripcion 
                // case 4:
                //     //validar el registro por el estado 
                // case 5:
                //     //
            }

            if(isset($array_asociativo["tipo_validacion_existencia"]) == false){
                if (empty($response_titulo_academico["data"][0])) throw new Exception("El registro ". ($array_asociativo["descripcion"]??"Registro")." no existe");        
            }else{
                if (!empty($response_titulo_academico["data"][0])) throw new Exception("El registro ". ($array_asociativo["descripcion"]??"Registro")." si existe");
            }
            
            if (!$response_titulo_academico["ok"]) throw new Exception($response_titulo_academico["msg_error"]);
            $response->setdata($response_titulo_academico);
        } catch (Exception $e) {
            log::alert("El error esta en las validaciones");
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        log::alert($response->getdata());
        return $response->getdata();
    }
}
