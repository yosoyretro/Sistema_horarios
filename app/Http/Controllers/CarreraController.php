<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Models\CarreraModel;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarreraController extends Controller
{

    public function storeCarrera(Request $request)
    {
        try{
            
            $modelo = new CarreraModel();
            $campos_requeridos = $modelo->getFillable();
            $campos_recibidos = array_keys($request->all());
            $campos_faltantes = array_diff($campos_requeridos, $campos_recibidos);
        
            if (!empty(array_diff($campos_requeridos, $campos_recibidos))) {
                return response()->json([
                    "ok" => false,
                    "message" => "Los siguientes campos son obligatorios: " . implode(', ', $campos_faltantes)
                ], 400);
            }
            
            $modelo->nombre = $request->nombre;
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

    public function deleteCarrera(Request $request,$id)
    {  
        try{
            $asignatura = CarreraModel::find($id);
            if(!$asignatura){
                return Response()->json([
                    "ok" => true,
                    "message" => "La carrera no existe con el id $id"
                ], 400);    
            }
            
            CarreraModel::find($id)->updated([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),

            ]);

            return Response()->json([
                "ok" => true,
                "message" => "Carrera eliminada con exito"
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

    public function updateCarrera(Request $request,$id)
    {
        try{
            $asignatura = CarreraModel::find($id);
            if(!$asignatura){
                return Response()->json([
                    "ok" => true,
                    "message" => "El registro no existe con el id $id"
                ],400);
            }
            CarreraModel::find($id)->update([
                "nombre" => isset($request->nombre)?$request->nombre:$asignatura->nombre,
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
                "estado" => isset($request->estado) ? $request->estado : "A"
            ]);
            return Response()->json([
                "ok" => true,
                "message" => "Carrera actualizada con exito"
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

    public function showCarrera()
    {
        try{
            $asignatura = CarreraModel::select("id_carrera","nombre","estado")->whereIn("estado",["A","I"])->get();
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
