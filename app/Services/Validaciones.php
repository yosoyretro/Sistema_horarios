<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Services\MensajeAlertasServicio;
use Exception;
use Illuminate\Support\Facades\Log;
use  App\Services\AsignaturaServicio;
use App\services\CarreraServicio;
use App\service\DiasServicio;
use App\Services\NivelServicio;
use App\services\ParaleloServicio;
use PhpParser\Node\Stmt\Switch_;

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
                case 2:
                    //validar registro por el nombre y codigo

                    if (!$array_asociativo["codigo"] && !$array_asociativo["nombre"]) throw new Exception("Error la clave del id_titulo_academico no existe");
                    if (!is_numeric($array_asociativo["codigo"])) throw new Exception("El dato no debe de ser string");
                    $response_instituto_academico = $servicio_insituto->Consultar([
                        "tipo_consulta" => 5,
                        "codigo" => $array_asociativo["codigo"],
                        "nombre" => $array_asociativo["nombre"]
                    ]);
                    log::alert("ESTO ES LO QUE ME RETORNI ");
                    log::alert($response_instituto_academico);

                    break;
            }

            log::alert("ESTO ES LO QUE RETORNA EL ISNTITUTLO RESPONSE");
            log::alert($response_instituto_academico);

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_instituto_academico["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " no existe");
            } else {
                if (!empty($response_instituto_academico["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " si existe");
            }
            if (!$response_instituto_academico["ok"]) throw new Exception($response_instituto_academico["msg_error"]);

            $response->setdata($response_instituto_academico);
        } catch (Exception $e) {

            log::alert("El error esta en las validaciones");
            log::alert("Linea del error : " . $e->getLine());
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        log::alert("ESTO ES LO QUE VOY A RETORBAR");
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

                    if (!isset($array_asociativo["codigo"]) && !isset($array_asociativo["descripcion"])) throw new Exception("Debes de enviar correctamente los datos");

                    $response_asignatura = $servicio_asignatura->Consultar([
                        "tipo_consulta" => 5,
                        "codigo" => $array_asociativo["codigo"],
                        "descripcion" => $array_asociativo["descripcion"],
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40402"
                    ]);

                    if (!$response_mensaje["ok"]) throw new Exception("Error interno en el servidor");
                    $mensaje = $response_mensaje["data"][0]["mensaje"];
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

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_asignatura["data"][0])) throw new Exception($mensaje);
            } else {
                log::alert("SOY EL ELSE");
                if (!empty($response_asignatura["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " ya existe");
            }

            if (!$response_asignatura["ok"]) throw new Exception($response_asignatura["msg_error"]);
            $response->setdata($response_asignatura["data"]);
        } catch (Exception $e) {
            log::alert("El error esta en las validaciones");
            log::alert("LINEA DEL ERROR : " . $e->getLine());
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return $response->getdata();
    }

    public function validarRegistroForCarrera($opcion, $array_asociativo)
    {
        $response = new TypeResponse();
        log::alert("Soy el validar registro carrera");
        log::alert(collect($array_asociativo));
        
        try {
            $servicio_carrera = new CarreraServicio();
            switch ($opcion) {
                case 1:
                    if (!isset($array_asociativo["id_carrera"])) throw new Exception("Hace falta lo que el es el id_carrera");
                    //if (is_numeric($array_asociativo["id_carrera"])) throw new Exception("El dato debe de ser un numero");
                    $response_asignatura = $servicio_carrera->Consultar(array_merge(["tipo_consulta" => 1], $array_asociativo));
                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40401"
                    ]);
                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;
                case 2:
                    if (!isset($array_asociativo["codigo"]) && !isset($array_asociativo["nombre"])) throw new Exception("Hace falta el codigo o nombre como clave");
                    $response_asignatura = $servicio_carrera->Consultar(array_merge(["tipo_consulta" => 5], $array_asociativo));
                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40401"
                    ]);
                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;
            }

            if (!$response_asignatura["ok"]) throw new Exception($servicio_carrera["msg_error"]);

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_asignatura["data"][0])) throw new Exception($mensaje);
            } else {
                log::alert("Soy el else");
                if (!empty($response_asignatura["data"][0])) throw new Exception(($array_asociativo["descripcion"] ?? "Registro") . " ya existe");
            }
        } catch (Exception $e) {
            log::alert("SOy el error de la funcion validacion");
            log::alert($e->getMessage());
            log::alert("SOy la linea del error" . $e->getCode());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return $response->getdata();
    }

    
    public function validarRegistroForParalelo($opcion, $array_asociativo)
    {
        try {
            $response = new TypeResponse();
            $servicio_paralelo = new ParaleloServicio();

            if (!is_array($array_asociativo)) throw new Exception("El dato debe de ser un array asociativo");
            switch ($opcion) {
                case 1:
                    // Validar por ID de paralelo
                    if (!isset($array_asociativo["id_paralelo"])) throw new Exception("Error, la clave del ID de paralelo no existe");
                    if (!is_numeric($array_asociativo["id_paralelo"])) throw new Exception("El ID de paralelo debe ser numérico");

                    $response_paralelo = $servicio_paralelo->Consultar([
                        "tipo_consulta" => 1,
                        "data" => $array_asociativo["id_paralelo"]
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40404", 
                    ]);

                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;

                case 2:
                    // Validar por número de paralelo
                    if (!isset($array_asociativo["nemonico"])) throw new Exception("Error, la clave del número de paralelo no existe");
                    
                    $response_paralelo = $servicio_paralelo->Consultar([
                        "tipo_consulta" => 2,
                        "data" => $array_asociativo["nemonico"]
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40404",
                    ]);

                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;

                default:
                    throw new Exception("Opción de validación de paralelo no válida");
            }

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_paralelo["data"][0])) throw new Exception($mensaje);
            } else {
                if (!empty($response_paralelo["data"][0])) throw new Exception("El paralelo ya existe");
            }

            if (!$response_paralelo["ok"]) throw new Exception($response_paralelo["msg_error"]);
            $response->setdata($response_paralelo["data"]);

        } catch (Exception $e) {
            log::alert("El error está en las validaciones de paralelo");
            log::alert("LINEA DEL ERROR: " . $e->getLine());
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return $response->getdata();
    }

    public function validarRegistroForNivel($opcion, $array_asociativo)
    {
        try {
            $response = new TypeResponse();
            $servicio_nivel = new NivelServicio();

            if (!is_array($array_asociativo)) throw new Exception("El dato debe de ser un array asociativo");
            switch ($opcion) {
                case 1:
                    // Validar por ID de nivel
                    if (!isset($array_asociativo["id_nivel"])) throw new Exception("Error, la clave del ID de nivel no existe");
                    if (!is_numeric($array_asociativo["id_nivel"])) throw new Exception("El ID de nivel debe ser numérico");

                    $response_nivel = $servicio_nivel->Consultar([
                        "tipo_consulta" => 1,
                        "data" => $array_asociativo["id_nivel"]
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40406", 
                    ]);
                    log::alert("Soy el response del mensaje ");
                    log::alert($response_mensaje);
                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;

                case 2:
                    // Validar por número de nivel
                    if (!isset($array_asociativo["numero"])) throw new Exception("Error, la clave del número de nivel no existe");
                    if (!is_numeric($array_asociativo["numero"])) throw new Exception("El número de nivel debe ser numérico");

                    $response_nivel = $servicio_nivel->Consultar([
                        "tipo_consulta" => 2,
                        "data" => $array_asociativo["numero"]
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40407", 
                    ]);

                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;

                default:
                    throw new Exception("Opción de validación de nivel no válida");
            }

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_nivel["data"][0])) throw new Exception($mensaje);
            } else {
                if (!empty($response_nivel["data"][0])) throw new Exception("El nivel ya existe");
            }

            if (!$response_nivel["ok"]) throw new Exception($response_nivel["msg_error"]);
            $response->setdata($response_nivel["data"]);

        } catch (Exception $e) {
            log::alert("El error está en las validaciones de nivel");
            log::alert("LINEA DEL ERROR: " . $e->getLine());
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return $response->getdata();
    }

    public function validarRegistroForDia($opcion, $array_asociativo)
    {
        try {
            $response = new TypeResponse();
            $servicio_dias = new DiasServicio();

            if (!is_array($array_asociativo)) throw new Exception("El dato debe de ser un array asociativo");
            switch ($opcion) {
                case 1:
                    // Validar por ID de día
                    if (!isset($array_asociativo["id_dias"])) {
                        throw new Exception("Error, la clave del ID de día no existe");
                    }
                    if (!is_numeric($array_asociativo["id_dias"])) {
                        throw new Exception("El ID de día debe ser numérico");
                    }

                    $response_dia = $servicio_dias->Consultar([
                        "tipo_consulta" => 1,
                        "data" => $array_asociativo["id_dias"]
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40406",
                    ]);

                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;

                case 2:
                    // Validar por nombre de día
                    if (!isset($array_asociativo["dia"])) {
                        throw new Exception("Error, la clave del nombre de día no existe");
                    }

                    $response_dia = $servicio_dias->Consultar([
                        "tipo_consulta" => 2,
                        "data" => $array_asociativo["dia"]
                    ]);

                    $response_mensaje = $this->servicio_mensaje_alertas->consultar(1, [
                        "codigo" => "40407",
                    ]);

                    $mensaje = $response_mensaje["data"][0]["mensaje"];
                    break;

                default:
                    throw new Exception("Opción de validación de día no válida");
            }

            if ((isset($array_asociativo["tipo_validacion_existencia"])) && ($array_asociativo["tipo_validacion_existencia"] == false)) {
                if (empty($response_dia["data"][0])) {
                    throw new Exception($mensaje);
                }
            } else {
                if (!empty($response_dia["data"][0])) {
                    throw new Exception("El día ya existe");
                }
            }

            if (!$response_dia["ok"]) {
                throw new Exception($response_dia["msg_error"]);
            }

            $response->setdata($response_dia["data"]);
        } catch (Exception $e) {
            log::alert("El error está en las validaciones de día");
            log::alert("LINEA DEL ERROR: " . $e->getLine());
            log::alert($e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return $response->getdata();
    }

}
