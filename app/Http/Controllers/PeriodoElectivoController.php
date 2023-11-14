<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Models\PeriodoElectivoModel;
use App\Services\PeriodoElectivoServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PeriodoElectivoController extends Controller
{
    //Vista del PeriodoElectivo 
    private $obj_service_PeriodoElectivo,$validaciones_clase;

    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->obj_service_PeriodoElectivo = new PeriodoElectivoServicio();

    }

    public function showPeriodoElectivo(Request $request)
    {
        try{
            $response = new TypeResponse();
            $obj_service_PeriodoElectivo = $this->obj_service_PeriodoElectivo->ConsultarPeriodo(6);
            $response->setdata($obj_service_PeriodoElectivo["data"]);
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }

    //Crear PeriodoElectivo
    public function CreatePeriodo(Request $request){

        try {
            $response = new TypeResponse();
            $datos = [
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_termina' => $request->input('fecha_termina')
            ];
            
            $validacion_periodo = $this->validaciones_clase->validarRegistroForPeriodoElectivo(2, array_merge($datos,["tipo_validacion_existencia" => true]));
            if(!$validacion_periodo["ok"]) throw new Exception($validacion_periodo["msg_error"]);

            $request_servicio = $this->obj_service_PeriodoElectivo->CreatePeriodo($datos);
            if(!$request_servicio["ok"]) throw new Exception($request_servicio["msg_error"]);

            $response->setmensagge("Periodo Electivo Creado con exito !");

        } catch(Exception $e){
            log::alert("Funcion de CreatePeriodo");
            log::alert("Linea del error :" . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());

        }

        return json_decode($response->getdata());


    }
    
    
    //Actualizar el  PeriodoElectivo
    public function UpdatePeriodo(Request $request)
    {
        
        try{
            $response = new TypeResponse();

            $validacion_periodo = $this->validaciones_clase->validarRegistroForPeriodoElectivo(1, $request->all());
            if (!$validacion_periodo["ok"]) throw new Exception($validacion_periodo["msg_error"]);
            if (!$validacion_periodo["ok"] && !$validacion_periodo["data"]) throw new Exception($validacion_periodo["exception"]);

            $obj_service_PeriodoElectivo = $this->obj_service_PeriodoElectivo->UpdatePeriodo($request->all());
            if (!$obj_service_PeriodoElectivo["ok"]) throw new Exception($obj_service_PeriodoElectivo["msg_error"]);

            $response->setmensagge("Periodo Electivo actualizado con éxito");
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());

    }



    #Eliminar PeriodoElectivo
    public function DeletePeriodo(Request $request)
    {
        try {
            $response = new TypeResponse();

            $validacion_periodo = $this->validaciones_clase->validarRegistroForPeriodoElectivo(1, ["id_periodo_electivo" => $request->input('id_periodo_electivo')]);
            if (!$validacion_periodo["ok"]) throw new Exception($validacion_periodo["msg_error"]);
            if (!$validacion_periodo["ok"] && !$validacion_periodo["data"]) throw new Exception($validacion_periodo["exception"]);

            $obj_service_PeriodoElectivo = $this->obj_service_PeriodoElectivo->DeletePeriodo($request->input('id_periodo_electivo'));
            if (!$obj_service_PeriodoElectivo["ok"]) throw new Exception($obj_service_PeriodoElectivo["msg_error"]);

            $response->setmensagge("Periodo Electivo eliminado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge("A ocurrido un error en eliminar el PeriodoElectivo");
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());

    }
}
