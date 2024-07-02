<?php

namespace App\Http\Controllers;

use App\Services\UsuarioServicio;
use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use App\Services\TituloAcademicoServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Support\Facades\Log;

class TituloAcademicoController extends Controller
{
    private $validaciones_clase, $servicio_titulos_academico_clase, $servicio_usuarios;

    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->servicio_usuarios = new UsuarioServicio();
        $this->servicio_titulos_academico_clase = new TituloAcademicoServicio();
    }

    public function showTituloAcademico(Request $request)
    {
        $response = new TypeResponse();
        try {
            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->consultarTitulo(7);
            $response->setdata($servicio_titulos_academico["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return response()->json($response->getdata());
    }

    public function createTituloAcademico(Request $request)
    {
        $response = new TypeResponse();
        try {
            $request_servicio = $this->servicio_titulos_academico_clase->CreateTitulo($request->toArray());
            Log::alert(collect($response->getdata()));
            if (!$request_servicio["ok"]) {
                throw new Exception($request_servicio["msg_error"]);
            }
            $response->setmensagge("El título de " . strtoupper($request->input('descripcion')) . " se creó con éxito");
        } catch (Exception $e) {
            Log::alert("Función de createTituloAcademico");
            Log::alert("Línea del error: " . $e->getLine());
            $response->setok(false);
            $response->setmensagge($e->getMessage());
        }

        return response()->json($response->getdata());
    }

    public function updateTituloAcademico(Request $request)
    {
        $response = new TypeResponse();
        try {
            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->updateTituloAcademico($request->all());
            if (!$servicio_titulos_academico["ok"]) {
                throw new Exception($servicio_titulos_academico["msg_error"]);
            }
            $response->setmensagge("Título actualizado con éxito, verifique la información");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return response()->json($response->getdata());
    }

    public function deleteTituloAcademico(Request $request)
    {
        $response = new TypeResponse();
        try {
            Log::alert("Soy el request");
            Log::alert($request);

            $response_usuario = $this->servicio_usuarios->ConsultarUsuario(["tipo_consulta" => 4]);
            $info = $response_usuario["data"];

            $info->map(function ($dato) use ($request) {
                $info_validador = collect($dato["id_titulo_academico"])->where("id_titulo_academico", $request->input("id_titulo_academico"));

                if (count($dato["id_titulo_academico"]) == 1 && $info_validador) {
                    if (!$request_usuario = $this->servicio_usuarios->DeleteUsuario($dato->id_usuario)["ok"]) {
                        throw new Exception($request_usuario["msg"]);
                    }
                } else if (count($dato["id_titulo_academico"]) > 1 && $info_validador) {
                    $arreglo_titulos = [];
                    foreach ($dato["id_titulo_academico"] as $value) {
                        if ($request->input("id_titulo_academico") != $value->id_titulo_academico) {
                            array_push($arreglo_titulos, $value->id_titulo_academico);
                        } else {
                            $descripcion = $value->descripcion;
                        }
                    }
                    $this->servicio_usuarios->UpdateUsuario([
                        "id_usuario" => $dato->id_usuario,
                        "cedula" => $dato->cedula,
                        "nombres" => $dato->nombres,
                        "usuario" => $dato->usuario,
                        "id_rol" => $dato->id_rol->id_rol,
                        "id_titulo_academico" => $arreglo_titulos
                    ]);
                }
            });

            $servicio_titulos_academico = $this->servicio_titulos_academico_clase->deleteTituloAcademico($request->input('id_titulo_academico'));

            if (!$servicio_titulos_academico["ok"]) {
                throw new Exception($servicio_titulos_academico["msg_error"]);
            }

            $response->setmensagge("El título se eliminó con éxito, verifique la información");
        } catch (Exception $e) {
            Log::alert("Mensaje: " . $e->getMessage());
            Log::alert("Línea: " . $e->getLine());
            $response->setok(false);
            $response->setmensagge("Ha ocurrido un error al eliminar el título académico");
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return response()->json($response->getdata());
    }
}
