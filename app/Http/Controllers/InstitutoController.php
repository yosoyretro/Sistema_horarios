<?php

namespace App\Http\Controllers;

use App\Models\InstitutoModel;
use App\Models\TituloAcademicoModel;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstitutoController extends Controller
{

    public function storeInstituto(Request $request)
    {
        try {
            if (!isset($request->codigo)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo del codigo es obligatorio"
                ], 400);
            }

            if (!isset($request->nemonico)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo del nemonico es obligatorio"
                ], 400);
            }

            if (!isset($request->nombre)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo del nombre es obligatorio"
                ], 400);
            }

            if (!isset($request->descripcion)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo de descripcion es obligatorio"
                ], 400);
            }

            if (!isset($request->ubicacion)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo de ubicacion es obligatorio"
                ], 400);
            }

            if (!isset($request->jornada)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo de jornada es obligatorio"
                ], 400);
            }

            if (!isset($request->nivel_educacion)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo de nivel_educacion es obligatorio"
                ], 400);
            }

            if (isset($request->imagen)) {
                $imagen = json_encode($request->imagen);
            } else {
                $imagen = null;
            }

            $modelo = new InstitutoModel();
            $modelo->codigo = $request->codigo;
            $modelo->nemonico = $request->nemonico;
            $modelo->nombre = $request->nombre;
            $modelo->descripcion = $request->descripcion;
            $modelo->ubicacion = $request->ubicacion;
            $modelo->jornada = $request->jornada;
            $modelo->nivel_educacion = $request->nivel_educacion;
            $modelo->ip_creacion = $request->ip();
            $modelo->ip_actualizacion = $request->ip();
            $modelo->id_usuario_creador = auth()->id() ?? 1;
            $modelo->id_usuario_actualizo = auth()->id() ?? 1;
            $modelo->image = $imagen;
            $modelo->estado = "A";
            $modelo->save();

            return Response()->json([
                "ok" => true,
                "message" => "Titulo creado con exito"
            ], 200);
        } catch (Exception $e) {
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function showInstituto(Request $request)
    {
        try {
            $titulo = InstitutoModel::whereIn("estado", "A");
            return Response()->json([
                "ok" => true,
                "message" => "Titulos obtenidos con exito",
                "data" => $titulo
            ], 200);
        } catch (Exception $e) {
            log::error("A ocurrido un error : " . __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function updateInstituto(Request $request)
    {
        try {
            if (!isset($request->id)) {
                log::info(__FILE__ . " >  " . __FUNCTION__);
                log::info("Recurde que el campo del id es obligatorio para poder actualizar el instituto");
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo del id es obligatorio"
                ], 400);
            }

            $insituto = InstitutoModel::find($request->id);

            if ($insituto) {
                return Response()->json(
                    [
                        "ok" => true,
                        "message" => "No existe el insituto con el id $request->id"
                    ],400
                );
            }

            $modelo = InstitutoModel::where("id_insituto", $request->id)->update([
                "codigo" => isset($request->codigo)?$request->codigo : $insituto->codigo,
                "nemonico" => isset($request->nemonico)?$request->nemonico : $insituto->nemonico,
                "nombres" => isset($request->nombres)?$request->nombres : $insituto->nombres,
                "descripcion" => isset($request->descripcion)?$request->descripcion : $insituto->descripcion,
                "ubicacion" => isset($request->ubicacion)?$request->ubicacion : $insituto->ubicacion,
                "jornada" => isset($request->jornada)?$request->jornada : $insituto->jornada,
                "nivel_ubicacion" => isset($request->nivel_ubicacion)?$request->nivel_ubicacion : $insituto->nivel_ubicacion,
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
                "estado" => isset($request->estado) ? $request->estado : "A"
            ]);
            return Response()->json([
                "ok" => true,
                "message" => "Titulo actualizados con exito"
            ], 200);
        } catch (Exception $e) {
            log::error("A ocurrido un error : " . __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());
            return Response()->json([
                "ok" => false,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function deleteInstituto(Request $request)
    {
        try {
            if (!isset($request->id)) {
                log::info(__FILE__ . " >  " . __FUNCTION__);
                log::info("Recurde que el campo del id es obligatorio para poder eliminar el instituto");
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo del id es obligatorio"
                ], 400);
            }

            $modelo = InstitutoModel::where("id_insituto", $request->id)->update([
                "id_usuario_actualizo" => auth()->id(),
                "ip_actualizo" => $request->ip(),
                "estado" => "E"
            ]);

            return Response()->json([
                "ok" => true,
                "message" => "Titulo actualizados con exito"
            ], 200);
        } catch (Exception $e) {
            log::error("A ocurrido un error : " . __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());
            return Response()->json([
                "ok" => false,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }
}