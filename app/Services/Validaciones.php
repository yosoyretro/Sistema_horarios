<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Services\MensajeAlertasServicio;
use Exception;
use Illuminate\Support\Facades\Log;
use  App\Services\AsignaturaServicio;

class Validaciones
{

    private $servicio_mensaje_alertas;

    public function __construct()
    {
        $this->servicio_mensaje_alertas = new MensajeAlertasServicio();
    }
    public function validarRegistroForTituloAcademico($opcion, $array_asociativo)
    {
        try {
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
                    if (!isset($array_asociativo["descripcion"]) || !isset($array_asociativo["codigo"])) throw new Exception("Debe de envviar correctamente los datos");
                    $response_titulo_academico = $servicio_titulo_academico->consultarTitulo(5, [
                        "codigo" => $array_asociativo["codigo"],
                        "descripcion" => $array_asociativo["descripcion"],
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

            if (isset($array_asociativo["tipo_validacion_existencia"]) == false) {
                if (empty($response_titulo_academico["data"][0])) throw new Exception("El registro " . ($array_asociativo["descripcion"] ?? "Registro") . " no existe");
            } else {
                if (!empty($response_titulo_academico["data"][0])) throw new Exception("El registro " . ($array_asociativo["descripcion"] ?? "Registro") . " si existe");
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

    public function validarRegistroForInstituto($opcion, $array_asociativo)
    {
        $response = new TypeResponse();
        try {
            $servicio_insituto = new InstitutoServicio();

            if (!is_array($array_asociativo)) throw new Exception("El dato debe de ser un array asociativo");
            switch ($opcion) {
                case 1:
                    //validar registro por el id
                    if (!$array_asociativo["id_instituto"]) throw new Exception("Error la clave del id_titulo_academico no existe");
                    if (!is_numeric($array_asociativo["id_instituto"])) throw new Exception("El dato no debe de ser string");
                    $response_instituto_academico = $servicio_insituto->Consultar([
                        "tipo_consulta" => 1,
                        "id_instituto" => $array_asociativo["id_instituto"]
                    ]);
                    break;
            }

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_instituto_academico["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " no existe");
            } else {
                if (!empty($response_instituto_academico["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " si existe");
            }

            if (!$response_instituto_academico["ok"]) throw new Exception($response_instituto_academico["msg_error"]);
            $response->setdata($response_instituto_academico["data"][0]);
        } catch (Exception $e) {
            log::alert("El error esta en las validaciones");
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        log::alert($response->getdata());
        return $response->getdata();
    }

    public function validarRegistroForAsignatura($opcion, $array_asociativo)
    {
        try {

            $response = new TypeResponse();
            $servicio_asignatura = new AsignaturaServicio();

            if (!is_array($array_asociativo)) throw new Exception("El dato debe de ser un array asociativo");
            switch ($opcion) {
                case 1:
                    //validar registro por el id
                    if (!$array_asociativo["id_asignatura"]) throw new Exception("Error la clave del id_asignatura no existe");
                    if (!is_numeric($array_asociativo["id_asignatura"])) throw new Exception("El dato no debe de ser string");
                    $response_asignatura = $servicio_asignatura->Consultar([
                        "tipo_consulta" => 1,
                        "data" => $array_asociativo["id_asignatura"]
                    ]);
                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40401"
                    ]);
                    $mensaje = $response_mensaje["data"][0]["mensaje"];

                    break;
                case 2:
                    //validar por codigo o por descripcion
                    if (!isset($array_asociativo["codigo"]) || !isset($array_asociativo["descripcion"])) throw new Exception("Debes de enviar correctamente los datos");
                    $response_asignatura = $servicio_asignatura->Consultar([
                        "tipo_consulta" => 5,
                        "codigo" => $array_asociativo["codigo"],
                        "descripcion" => $array_asociativo["descripcion"],
                    ]);
                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40402"
                    ]);

                    if (!$response_mensaje["ok"]) throw new Exception("Error interno en el servidor");

                    break;
                case 3:
                    //validar por codigo por descripcion y por id 
                    if (!isset($array_asociativo["codigo"]) || !isset($array_asociativo["descripcion"])) throw new Exception("Debes de enviar correctamente los datos");

                    $response_asignatura = $servicio_asignatura->Consultar([
                        "tipo_consulta" => 6,
                        "codigo" => $array_asociativo["codigo"],
                        "descripcion" => $array_asociativo["descripcion"],
                    ]);
                    
                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40402"
                    ]);
                    
                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;
            }
            log::alert("soy el mensaje");
            log::alert($mensaje);
            log::alert("SOY EL ARRAY");
            log::alert($array_asociativo);

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                log::alert("SOY EL IF");
                if (empty($response_asignatura["data"][0])) throw new Exception($mensaje);
            } else {
                log::alert("SOY EL ELSE");
                if (!empty($response_asignatura["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " ya existe");
            }

            if (!$response_asignatura["ok"]) throw new Exception($response_asignatura["msg_error"]);
            $response->setdata($response_asignatura["data"]);
        } catch (Exception $e) {
            log::alert("El error esta en las validaciones");
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return $response->getdata();
    }
}