<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\NivelServicio;

class NivelController extends Controller
{
    private $validaciones_clase, $servicio_nivel_clase;

    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->servicio_nivel_clase = new NivelServicio();
    }

    //VISTA DEL NIVEL
    public function showNivel(Request $request)
    {
        try {
            $response = new TypeResponse();
            $servicio_nivel = $this->servicio_nivel_clase->Consultar(["tipo_consulta" => 1]);
            $response->setdata($servicio_nivel["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    // Crear NIVEL
    public function createNivel(Request $request)
    {
        try {
            $response = new TypeResponse();
            $datos = [
                'numero' => $request->input('numero'),
                'descripcion' => $request->input('descripcion')
            ];

            // $validacion_nivel = $this->validaciones_clase->validarRegistroForNivel(2, array_merge($datos, ["tipo_validacion_existencia" => true]));
            // if (!$validacion_nivel["ok"]) throw new Exception($validacion_nivel["msg_error"]);

            $request_servicio = $this->servicio_nivel_clase->createNivel($datos);
            if (!$request_servicio["ok"]) throw new Exception($request_servicio["msg_error"]);

            $response->setmensagge("Nivel creado con éxito!");
        } catch (Exception $e) {
            log::alert("Funcion de createNivel");
            log::alert("Linea del error: " . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());
    }

    // ACTUALIZAR NIVEL
    public function updateNivel(Request $request)
    {
        try {
            $response = new TypeResponse();

            $validacion_nivel = $this->validaciones_clase->validarRegistroForNivel(1, $request->all());
            if (!$validacion_nivel["ok"]) throw new Exception($validacion_nivel["msg_error"]);
            if (!$validacion_nivel["ok"] && !$validacion_nivel["data"]) throw new Exception($validacion_nivel["exception"]);

            $servicio_nivel = $this->servicio_nivel_clase->UpdateNivel($request->all());
            if (!$servicio_nivel["ok"]) throw new Exception($servicio_nivel["msg_error"]);

            $response->setmensagge("Nivel actualizado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    // ELIMINAR NIVEL
    public function deleteNivel(Request $request)
    {
        try {
            $response = new TypeResponse();

            //$validacion_nivel = $this->validaciones_clase->validarRegistroForNivel(1, ["id_nivel" => $request->input('id_nivel')]);
            //if (!$validacion_nivel["ok"]) throw new Exception($validacion_nivel["msg_error"]);
            //if (!$validacion_nivel["ok"] && !$validacion_nivel["data"]) throw new Exception($validacion_nivel["exception"]);

            $servicio_nivel = $this->servicio_nivel_clase->DeleteNivel($request->input('id_nivel'));
            if (!$servicio_nivel["ok"]) throw new Exception($servicio_nivel["msg_error"]);

            $response->setmensagge("Registro eliminado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge("A ocurrido un error en eliminar el nivel");
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());
    }
}