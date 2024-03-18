<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Models\DistribucionHorario as ModelsDistribucionHorario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DistribucionHorario extends Controller
{
    //

    public function storeHorario(Request $request)
    {
        $response = new TypeResponse();
        try{
            DB::beginTransaction();
            $detalles = $request->input("detalles");
            $insert_data = collect($detalles)->map(function ($values) use ($request){
                $values = (object)$values;
                $consulta = ModelsDistribucionHorario::where("id_usuario",$request->input("id_usuario"))
                ->where("id_periodo_academico",$request->input("id_periodo_electivo"))
                ->where("id_educacion_global",$request->input("id_educacion_global"))
                ->where("id_materia",$values->id_materia)
                ->where("id_nivel",$values->id_curso)
                ->where("id_paralelo",$values->id_paralelo)
                ->where("hora_inicio",">=",Carbon::parse($values->hora_inicio))
                ->where("hora_termina","<=",Carbon::parse($values->hora_termina))
                ->get();
                if(count($consulta) > 0)throw new Exception("A ocurrido un error al crear este horario al parecer ya tiene una hora usando en el rango de " . $values->hora_inicio . " y " . $values->hora_termina);

                return [
                    "id_usuario" => $request->input("id_usuario"),
                    "id_periodo_academico" => $request->input("id_periodo_electivo"),
                    "id_educacion_global"=>$request->input("id_educacion_global"),
                    "id_materia"=>$values->id_materia,
                    "id_nivel" => $values->id_curso,
                    "id_paralelo" => $values->id_paralelo,
                    "hora_inicio" => Carbon::parse($values->hora_inicio),
                    "hora_termina" => Carbon::parse($values->hora_termina),
                ];
            });

            ModelsDistribucionHorario::insert(array_values($insert_data->toArray()));
            DB::commit();
            return Response()->json([
                "ok"=>true,
                "mensaje"=> "Horario creado con exito."
            ]);
        }catch(Exception $e){
            DB::rollBack();
            log::alert("A ocurrido un error");
            log::alert("Mensaje => " .$e->getMessage());
            log::alert("Linea => " .$e->getLine());
            $response->setok(false);
            $response->setmensagge($e->getMessage());            
            return Response()->json([
                "ok"=>false,
                "informacion"=>"",
                "mensaje_error"=> $e->getMessage()
            ]);
        }
        
    }




}
