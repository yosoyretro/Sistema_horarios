<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PlanificacionAcademicaModel;
use App\Models\PlanificacionHorarioModelo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Date;

use function Laravel\Prompts\error;

class PlanificacionAcademica extends Controller
{
    
    public function store(Request $request)
    {
        try{
            $info_request = $request->data;
            if(!is_array($info_request)){
                throw new Exception("Los parametros de esta api es que sean arreglo");
            }

            $inst = array_values(collect($info_request)->pluck("id_instituto")->unique()->toArray());
            $planificacion = PlanificacionAcademicaModel::whereIn("id_educacion_global",$inst)
            ->join("nivel","planificacion_academica.id_nivel","nivel.id_nivel")
            ->join("paralelo","planificacion_academica.id_paralelo","paralelo.id_paralelo")
            ->join("usuarios","usuarios.id_usuario","planificacion_academica.coordinador_carrera")
            ->where("planificacion_academica.estado","A")
            ->get();
            $arreglo = [];
            $info_insert = collect($info_request)->map(function($valor) use ($planificacion,$request){
                $valor = (object)$valor;
                $id_instituto = isset($valor->id_instituto) ? $valor->id_instituto : 0;
                $id_carrera = isset($valor->id_carrera) ? $valor->id_carrera : 0;
                $id_materia = isset($valor->id_materia) ? $valor->id_materia : 0;
                $id_curso = isset($valor->id_curso) ? $valor->id_curso : 0;
                $id_paralelo = isset($valor->id_paralelo) ? $valor->id_paralelo : 0;
                $id_coordinador = isset($valor->id_coordinador) ? $valor->id_coordinador : 0;
                $id_periodo_electivo = isset($valor->id_periodo_electivo) ? $valor->id_periodo_electivo : 0;
                
                $data = $planificacion->where("id_educacion_global",$id_instituto)
                ->where("id_carrera",$id_carrera)
                ->where("id_materia",$id_materia)
                ->where("id_nivel",$id_curso)
                ->where("id_paralelo",$id_paralelo)->first();
                if($data){
                    throw new Exception("Error ya existe una planificacion Academica");
                }
                return [
                    "id_educacion_global" => $id_instituto,
                    "id_carrera" => $id_carrera,
                    "id_materia" => $id_materia,
                    "id_nivel" => $id_curso,
                    "id_paralelo" => $id_paralelo,
                    "coordinador_carrera" => $id_coordinador, 
                    "id_periodo_academico" => $id_periodo_electivo,
                    "ip_creacion" => $request->ip(),
                    "ip_actualizacion" => $request->ip(),   
                    "id_usuario_creador" => 1,
                    "id_usuario_actualizo" => 1,
                    "fecha_creacion" => Carbon::now(),
                    "fecha_actualizacion" => Carbon::now()
                ];
            });

            PlanificacionAcademicaModel::insert(array_values($info_insert->toArray()));
            log::info("Planificacion creada con exito");
            return Response()->json([
                "ok" => true,
                "message" => "Planificacion creada con exito"
            ],200); 
        }catch(Exception $e){
            //23000 codigo ambiguo de SQL
            log::error(__FILE__ ." > ". __FUNCTION__);
            log::error($e->getMessage());
            log::error($e->getLine());
            return Response()->json([
                "ok" => false,
                "message" => $e->getMessage()
            ],500); 
        }
    }

    public function getPlanificacionAcademica(){
        try{

            $data = PlanificacionAcademicaModel::select(
                "carreras.id_carrera"
                ,"carreras.nombre as nombre_carrera"
                ,"educacion_global.*"
                ,"materias.*"
                ,"nivel.*"
                ,"paralelo.*"
                ,"usuarios.*"
                ,"planificacion_academica.fecha_actualizacion"
            )
            ->join("materias","planificacion_academica.id_materia","materias.id_materia")
            ->join("carreras","planificacion_academica.id_carrera","carreras.id_carrera")
            ->join("nivel","planificacion_academica.id_nivel","nivel.id_nivel")
            ->join("paralelo","planificacion_academica.id_paralelo","paralelo.id_paralelo")
            ->join("usuarios","usuarios.id_usuario","planificacion_academica.coordinador_carrera")
            ->join("educacion_global","educacion_global.id_educacion_global","planificacion_academica.id_educacion_global")
            ->orderBy("paralelo.paralelo")
            ->get()
            ->map(function ($valor){
                return [
                    "id_educacion_global" => $valor->id_educacion_global,
                    "educacion_global" => $valor->nombre,
                    "id_carrera" => $valor->id_carrera,
                    "carrera" => $valor->nombre_carrera,
                    "id_materia" => $valor->id_materia,
                    "materia" => $valor->descripcion,
                    "id_nivel" => $valor->id_nivel,
                    "nivel" => $valor->nemonico ." " . $valor->termino,
                    "id_paralelo" => $valor->id_paralelo,
                    "paralelo" => $valor->paralelo,
                    "id_coordinador" => $valor->id_usuario,
                    "coordinador" => $valor->nombres . " "  . $valor->apellidos,
                    "fecha_ultima_actualizacion" => $valor->fecha_actualizacion
                ];
            });
            $response_data = collect($data)->pluck("id_carrera")->unique()->map(function ($item) use ($data){
                $materias = collect($data)->where("id_carrera",$item)
                ->pluck("id_materia")
                ->unique();
                $info = (object)collect($data)->where("id_carrera",$item)->first();
                $retorna_arreglo = collect([]);
                foreach($materias as $materia){
                    $extras = array_values(collect($data)->where("id_carrera",$item)
                    ->where("id_materia",$materia)
                    ->map(function ($arreglos){

                            return [
                                "id_materia" => $arreglos["id_materia"],
                                "materia" => $arreglos["materia"],
                                "id_curso" => $arreglos["id_nivel"],
                                "curso" => $arreglos["nivel"],
                                "id_paralelo" => $arreglos["id_paralelo"],
                                "paralelo" => $arreglos["paralelo"]
                            ];
                    })->toArray());
                    
                    $retorna_arreglo->push($extras);
                }
                return [
                    "id_educacion_global" => $info->id_educacion_global,
                    "educacion_global" => $info->educacion_global,
                    "id_carrera" => $info->id_carrera,
                    "carrera" => $info->carrera,
                    "coordinador" => $info->coordinador,
                    "detalles" => array_values($retorna_arreglo->toArray()),
                    "fecha_ultima_actualizacion" => $info->fecha_ultima_actualizacion,
                ];
            });
            
            return Response()->json([
                "ok" => true,
                "data" => $response_data
            ],200);
        }catch(Exception $e){
            log::error(__FILE__ . " > " . __FUNCTION__);
            log::error($e->getMessage());
            log::error($e->getLine());
            return Response()->json([
                "ok" => false,
                "data" => "Error interno en el servidor " 
            ],500);
        }
    }
    /*SELECT materias.descripcion,CONCAT(nivel.nemonico," ",nivel.termino) AS nivel ,paralelo.paralelo,CONCAT(usuarios.nombres , " ", usuarios.apellidos) AS nombres_completos
    FROM planificacion_academica
    JOIN materias ON planificacion_academica.id_materia = materias.id_materia
    JOIN nivel ON planificacion_academica.id_nivel = nivel.id_nivel
    JOIN paralelo ON planificacion_academica.id_paralelo = paralelo.id_paralelo
    JOIN usuarios ON usuarios.id_usuario = planificacion_academica.coordinador_carrera
    ORDER BY(paralelo.paralelo)*/
}
