<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use App\Services\ParaleloServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Support\Facades\Log;


class ParaleloController extends Controller
{
    private $validaciones_clase, $servicio_paralelo_clase;

    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->servicio_paralelo_clase = new ParaleloServicio();
    }

    //VISTA DEL PARALELO
    public function showParalelo(Request $request)
    {
        try {
            $response = new TypeResponse();
            $servicio_paralelo = $this->servicio_paralelo_clase->Consultar(["tipo_consulta" => 1]);
            $response->setdata($servicio_paralelo["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    // Crear PARALELO
    public function createParalelo(Request $request)
    {
        try {

            $response = new TypeResponse();
            $datos = [
                'nemonico' => $request->input('nemonico'),
            ];
            $validacion_paralelo = $this->validaciones_clase->validarRegistroForParalelo(2, array_merge($datos, ["tipo_validacion_existencia" => true]));
            if (!$validacion_paralelo["ok"]) throw new Exception($validacion_paralelo["msg_error"]);

            $request_servicio = $this->servicio_paralelo_clase->CreateParalelo($datos);
            if (!$request_servicio["ok"]) throw new Exception($request_servicio["msg_error"]);

            $response->setmensagge("Paralelo creado con éxito!");
        } catch (Exception $e) {
            log::alert("Funcion de createParalelo");
            log::alert("Linea del error: " . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_decode($response->getdata());
    }

    // ACTUALIZAR PARALELO
    public function updateParalelo(Request $request)
    {
        try {
            $response = new TypeResponse();

            $validacion_paralelo = $this->validaciones_clase->validarRegistroForParalelo(1, $request->all());
            if (!$validacion_paralelo["ok"]) throw new Exception($validacion_paralelo["msg_error"]);
            if (!$validacion_paralelo["ok"] && !$validacion_paralelo["data"]) throw new Exception($validacion_paralelo["exception"]);

            $servicio_paralelo = $this->servicio_paralelo_clase->UpdateParalelo($request->all());
            if (!$servicio_paralelo["ok"]) throw new Exception($servicio_paralelo["msg_error"]);

            $response->setmensagge("Paralelo actualizado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    // ELIMINAR PARALELO
    public function deleteParalelo(Request $request)
    {
        try {
            $response = new TypeResponse();

            // $validacion_paralelo = $this->validaciones_clase->validarRegistroForParalelo(1, ["id_paralelo" => $request->input('id_paralelo')]);
            // if (!$validacion_paralelo["ok"]) throw new Exception($validacion_paralelo["msg_error"]);
            // if (!$validacion_paralelo["ok"] && !$validacion_paralelo["data"]) throw new Exception($validacion_paralelo["exception"]);

            $servicio_paralelo = $this->servicio_paralelo_clase->DeleteParalelo($request->input('id_paralelo'));
            if (!$servicio_paralelo["ok"]) throw new Exception($servicio_paralelo["msg_error"]);

            $response->setmensagge("Registro eliminado con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge("A ocurrido un error en eliminar el paralelo");
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());
    }
}