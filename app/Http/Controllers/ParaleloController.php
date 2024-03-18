<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use App\Models\ParaleloModel;
use App\Services\ParaleloServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Support\Facades\Log;


class ParaleloController extends Controller
{
    public function storeParalelo(Request $request)
    {
        try{
            
            $modelo = new ParaleloModel();
            $campos_requeridos = $modelo->getFillable();
            $campos_recibidos = array_keys($request->all());
            $campos_faltantes = array_diff($campos_requeridos, $campos_recibidos);
        
            if (!empty(array_diff($campos_requeridos, $campos_recibidos))) {
                return response()->json([
                    "ok" => false,
                    "message" => "Los siguientes campos son obligatorios: " . implode(', ', $campos_faltantes)
                ], 400);
            }
            
            $modelo->paralelo = $request->paralelo;
            $modelo->ip_creacion = $request->ip();
            $modelo->ip_actualizacion = $request->ip();
            $modelo->id_usuario_creador = auth()->id() ?? 1;
            $modelo->id_usuario_actualizo = auth()->id() ?? 1;
            $modelo->estado = "A";
            $modelo->save();
            return Response()->json([
                "ok" => true,
                "message" => "Carrera creada con exito"
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


    public function deleteParalelo(Request $request,$id)
    {  
        try{
            $asignatura = ParaleloModel::find($id);
            if(!$asignatura){
                return Response()->json([
                    "ok" => true,
                    "message" => "El paralelo no existe con el id $id"
                ], 400);    
            }
            
            ParaleloModel::find($id)->updated([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),

            ]);

            return Response()->json([
                "ok" => true,
                "message" => "Carrera eliminada con exito"
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

    public function showParalelo()
    {
        try{
            $paralelo = ParaleloModel::select("paralelo","estado")->whereIn("estado",["A","I"])->get();
            return Response()->json([
                "ok" => true,
                "data" => $paralelo
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

    public function updateParalelo(Request $request,$id)
    {
        try{
            $insituto = ParaleloModel::find($id);

            if ($insituto) {
                return Response()->json(
                    [
                        "ok" => true,
                        "message" => "No existe un paralelo con el id $id"
                    ],400
                );
            }

            $modelo = ParaleloModel::where("id_insituto", $id)->update([
                "paralelo" => $request->paralelo,
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
                "estado" => isset($request->estado) ? $request->estado : "A"
            ]);


            return Response()->json([
                "ok" => true,
                "message" => "Paralelo actualizado con exito"
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