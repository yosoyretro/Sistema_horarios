<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Services\CarreraServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarreraController extends Controller
{
    private $servicio_carrera, $servicio_validaciones;
    public function __construct()
    {
        $this->servicio_carrera = new CarreraServicio();
        $this->servicio_validaciones = new Validaciones();
    }

    public function createCarrera(Request $request)
    {
        $response = new TypeResponse();
        try {
            $validaciones = $this->servicio_validaciones->validarRegistroForCarrera(2, $request->all());
            if (!$validaciones["ok"]) throw new Exception($validaciones["msg_error"]);
            $service_carrera = $this->servicio_carrera->CreateCarrera($request->all());
            if (!$service_carrera["ok"]) throw new Exception($service_carrera["msg_error"]);
        } catch (Exception $e) {
            log::alert("ENTRO EN EL ERROR DE CREATE CARRERA");
            log::alert("Soy el codigo : " . $e->getCode());
            log::alert("Soy el mensaje : " . $e->getMessage());
            log::alert("Soy la linea : " . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getCode());
        }
        return json_encode($response->getdata());
    }

    public function updateCarrera(Request $request)
    {

        $response = new TypeResponse();
        try {
            $validaciones = $this->servicio_validaciones->validarRegistroForCarrera(1, array_merge($request->all(), ["tipo_validacion_existencia" => false]));
            if (!$validaciones["ok"]) throw new Exception($validaciones["msg_error"]);

            $service_carrera = $this->servicio_carrera->updateCarrera($request->all());
            if (!$service_carrera["ok"]) throw new Exception($service_carrera["msg_error"]);
        } catch (Exception $e) {
            log::alert("SOY EL ERRORR DEL CONTROLADOR ");
            log::alert("Soy el codigo : " . $e->getCode());
            log::alert("Soy el mensaje : " . $e->getMessage());
            log::alert("Soy la linea : " . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getCode());
        }
        return json_encode($response->getdata());

        $service = $this->servicio_carrera->updateCarrera($request->all());
        return json_encode($service);
    }

    public function deleteCarrera(Request $request)
    {
        $response = new TypeResponse();

        try {
            $validaciones = $this->servicio_validaciones->validarRegistroForCarrera(1, array_merge($request->all(), ["tipo_validacion_existencia" => false]));
            if (!$validaciones["ok"]) throw new Exception($validaciones["msg_error"]);
            $servicio_carrera = $this->servicio_carrera->deleteCarrera($request->all()["id_carrera"]);
            if(!$servicio_carrera["ok"])throw new Exception($servicio_carrera["msg_error"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getCode());
        }
        
        return json_encode($response->getdata());
    }

    public function showCarrera()
    {
        $service = $this->servicio_carrera->Consultar(["tipo_consulta" => 4]);
        return json_encode($service);
    }
}
