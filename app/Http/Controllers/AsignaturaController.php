<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Responses\TypeResponse;
use App\Models\AsignaturaModel;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function storeAsignatura(Request $request)
    {
        try{
            if (!isset($request->descripcion)) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El campo de descripcion es obligatorio"
                ], 400);
            }

            $modelo = new AsignaturaModel();
            $modelo->descripcion = $request->descripcion;
            $modelo->ip_creacion = $request->ip();
            $modelo->ip_actualizacion = $request->ip();
            $modelo->id_usuario_creador = auth()->id() ?? 1;
            $modelo->id_usuario_actualizo = auth()->id() ?? 1;
            $modelo->estado = "A";
            $modelo->save();

            return Response()->json([
                "ok" => true,
                "message" => "Asignatura creada con exito"
            ], 200);

        }catch(Exception $e){
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);

        }
    }

    public function deleteAsignatura(Request $request,$id)
    {
        try{
            $asignatura = AsignaturaModel::find($id);
            if(!$asignatura){
                return Response()->json([
                    "ok" => true,
                    "message" => "La asignatura no existe con el id $id"
                ], 400);
            }

            AsignaturaModel::find($id)->updated([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
            ]);

            return Response()->json([
                "ok" => true,
                "message" => "Asignatura creada con exito"
            ], 200);

        }catch(Exception $e){
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);

        }
    }

    public function updateAsignatura(Request $request,$id)
    {
        try{
            $asignatura = AsignaturaModel::find($id);
            if(!$asignatura){
                return Response()->json([
                    "ok" => true,
                    "message" => "El registro no existe con el id $id"
                ],400);
            }

            AsignaturaModel::find($id)->update([
                "descripcion" => isset($request->descripcion)?$request->descripcion:$asignatura->descripcion,
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
                "estado" => isset($request->estado) ? $request->estado : "A"
            ]);
            return Response()->json([
                "ok" => true,
                "message" => "Asignatura actualizada con exito"
            ],200);
        }catch(Exception $e){
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function showAsignatura()
    {
        try{
            $asignatura = AsignaturaModel::select("id_materia","descripcion")->whereIn("estado",["A","I"])->get();
            return Response()->json([
                "ok" => true,
                "data" => $asignatura
            ],200);
        }catch(Exception $e){
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => false,
                "message" => "Error interno en el servidor"
            ],500);
        }
    }
}
