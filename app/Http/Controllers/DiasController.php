<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use App\Service\DiasServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Support\Facades\Log;

class DiasController extends Controller
{
    private $validaciones_clase, $servicio_dias_clase;

    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->servicio_dias_clase = new DiasServicio();
    }

    public function showDias(Request $request)
    {
        try {
            $response = new TypeResponse();
            $servicio_dias = $this->servicio_dias_clase->Consultar([
                "tipo_consulta" => 2,
                "data" => $request->input('dia')
            ]);
            $response->setdata($servicio_dias["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    public function createDias(Request $request)
    {
        try {
            $response = new TypeResponse();
            $datos = [
                'dia' => $request->input('dia'),
            ];

            $validacion_dia = $this->validaciones_clase->validarRegistroForDia(2, array_merge($datos, ["tipo_validacion_existencia" => true]));
            if (!$validacion_dia["ok"]) throw new Exception($validacion_dia["msg_error"]);

            $request_servicio = $this->servicio_dias_clase->CreateDias($datos);
            if (!$request_servicio["ok"]) throw new Exception($request_servicio["msg_error"]);
            $response->setmensagge("Día guardado con éxito!");
        } catch (Exception $e) {
            log::alert("Funcion de createDias");
            log::alert("Linea del error :" . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(), $e);
        }

        return json_decode($response->getdata());
    }

    public function updateDias(Request $request)
    {
        try {
            $response = new TypeResponse();
            $validacion_dia = $this->validaciones_clase->validarRegistroForDia(1, $request->all());
            if (!$validacion_dia["ok"]) throw new Exception($validacion_dia["msg_error"]);
            if (!$validacion_dia["ok"] && !$validacion_dia["data"]) throw new Exception($validacion_dia["exception"]);

            $servicio_dias = $this->servicio_dias_clase->UpdateDias($request);
            if (!$servicio_dias["ok"]) throw new Exception($servicio_dias["msg_error"]);
            $response->setmensagge("Día actualizado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    public function deleteDias(Request $request)
    {
        try {
            $response = new TypeResponse();

            $validacion_dia = $this->validaciones_clase->validarRegistroForDia(1, ["id_dias" => $request->input('id_dias')]);

            if (!$validacion_dia["ok"]) throw new Exception($validacion_dia["msg_error"]);
            if (!$validacion_dia["ok"] && !$validacion_dia["data"]) throw new Exception($validacion_dia["exception"]);

            $servicio_dias = $this->servicio_dias_clase->DeleteDias($request->input('id_dias'));
            if (!$servicio_dias["ok"]) throw new Exception($servicio_dias["msg_error"]);

            $response->setmensagge("Registro eliminado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge("Ha ocurrido un error al eliminar el día");
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());
    }
}