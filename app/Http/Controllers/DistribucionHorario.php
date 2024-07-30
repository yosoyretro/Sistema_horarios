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
        try {
            DB::beginTransaction();
            $detalles = $request->input("data");
            $idUsuario = 1;
            $idPeriodoElectivo = 1;
            $idEducacionGlobal = 1;
            $insert_data = collect($detalles)->map(function ($values) use ($request, $idUsuario, $idPeriodoElectivo, $idEducacionGlobal){
                $values = (object)$values;
                $consulta = ModelsDistribucionHorario::where("id_usuario", $idUsuario)
                ->where("id_periodo_academico", $idPeriodoElectivo)
                ->where("id_educacion_global", $idEducacionGlobal)
                ->where("id_carrera", $values->id_carrera)
                ->where("id_materia", $values->id_materia)
                ->where("id_nivel", $values->id_curso)
                ->where("id_paralelo", $values->id_paralelo)
                ->where("dia", $values->dia)
                ->where("hora_inicio", $values->hora_inicio)
                ->where("hora_termina", $values->hora_termina)
                ->where("estado", "A")
                ->get();

                if ($consulta->count() > 0) {
                throw new Exception("Ocurrió un error al crear este horario, ya existe una hora en el rango de " . $values->hora_inicio . " y " . $values->hora_termina);
                }

                return [
                    "id_usuario" => $idUsuario,
                    "id_periodo_academico" => $idPeriodoElectivo,
                    "id_educacion_global" => $idEducacionGlobal,
                    "id_carrera" => $values->id_carrera,
                    "id_materia" => $values->id_materia,
                    "id_nivel" => $values->id_curso,
                    "id_paralelo" => $values->id_paralelo,
                    "dia" => $values->dia,
                    "hora_inicio" => $values->hora_inicio,
                    "hora_termina" => $values->hora_termina,
                    "ip_creacion" => $request->ip(),
                    "ip_actualizacion"=> $request->ip(),
                    "id_usuario_creador" => $idUsuario,
                    "id_usuario_actualizo" => $idUsuario,
                    "fecha_creacion" => now(),
                    "fecha_actualizacion" => now(),
                    "estado" => 'A'
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

    public function showDistribucion(Request $request)
    {
        try {
            $data = ModelsDistribucionHorario::select(
                "educacion_global.nombre as educacion_global_nombre",
                "carreras.nombre as nombre_carrera",
                "materias.descripcion as materia",
                "nivel.termino as nivel",
                "paralelo.paralelo",
                "distribuciones_horario_academica.dia",
                "distribuciones_horario_academica.hora_inicio",
                "distribuciones_horario_academica.hora_termina",
                "distribuciones_horario_academica.fecha_actualizacion"
                )
            ->join("educacion_global", "distribuciones_horario_academica.id_educacion_global", "educacion_global.id_educacion_global")
            ->join("carreras", "distribuciones_horario_academica.id_carrera", "carreras.id_carrera")
            ->join("materias", "distribuciones_horario_academica.id_materia", "materias.id_materia")
            ->join("nivel", "distribuciones_horario_academica.id_nivel", "nivel.id_nivel")
            ->join("paralelo", "distribuciones_horario_academica.id_paralelo", "paralelo.id_paralelo")
            ->orderBy("distribuciones_horario_academica.dia")
            ->get();

            return response()->json([
                "ok" => true,
                "data" => $data
            ], 200);
        } catch (Exception $e) {
            // Registro de logs de error
            Log::error(__FILE__ . " > " . __FUNCTION__);
            Log::error("Mensaje : " . $e->getMessage());
            Log::error("Línea : " . $e->getLine());

            // Respuesta JSON en caso de error
            return response()->json([
                "ok" => false,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function updateDistribucion(Request $request, $id)
    {
        try {
            // Buscar la distribución por ID
            $distribucion = ModelsDistribucionHorario::find($id);

            if (!$distribucion) {
                return response()->json([
                    "ok" => false,
                    "mensaje" => "El registro no existe con el ID $id."
                ], 400);
            }

            // Actualizar los campos condicionalmente
            $distribucion->update([
                "id_usuario" => $request->input('id_usuario', $distribucion->id_usuario),
                "id_periodo_academico" => $request->input('id_periodo_electivo', $distribucion->id_periodo_academico),
                "id_educacion_global" => $request->input('id_educacion_global', $distribucion->id_educacion_global),
                "id_materia" => $request->input('id_materia', $distribucion->id_materia),
                "id_nivel" => $request->input('id_nivel', $distribucion->id_nivel),
                "id_paralelo" => $request->input('id_paralelo', $distribucion->id_paralelo),
                "dia" => $request->input('dia', $distribucion->dia),
                "hora_inicio" => $request->input('hora_inicio', $distribucion->hora_inicio),
                "hora_termina" => $request->input('hora_termina', $distribucion->hora_termina),
                "fecha_actualizacion" => Carbon::now(),
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
                "estado" => $request->input('estado', $distribucion->estado)
            ]);

            return response()->json([
                "ok" => true,
                "mensaje" => "Distribución actualizada con éxito."
            ], 200);

        } catch (Exception $e) {
            // Registro de errores
            Log::error(__FILE__ . " > " . __FUNCTION__);
            Log::error("Mensaje: " . $e->getMessage());
            Log::error("Línea: " . $e->getLine());

            return response()->json([
                "ok" => false,
                "mensaje" => "Error interno en el servidor."
            ], 500);
        }
    }

    public function deleteDistribucion(Request $request)
    {
        try {
            // Obtener el ID del request
            $id = $request->input('id') ?? null;

            if (!$id) {
                return response()->json([
                    "ok" => false,
                    "mensaje" => "Error: Falta el parámetro del ID."
                ], 404);
            }

            // Buscar la distribución por ID
            $distribucion = ModelsDistribucionHorario::find($id);

            if (!$distribucion) {
                return response()->json([
                    "ok" => false,
                    "mensaje" => "Error: El registro no existe."
                ], 404);
            }

            // Actualizar el estado a eliminado y los datos de actualización
            $distribucion->update([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "fecha_actualizacion" => Carbon::now()
            ]);

        } catch (Exception $e) {
            return response()->json([
                "ok" => false,
                "mensaje" => "Error interno en el servidor."
            ], 500);
        } finally {
            return response()->json([], 202);
        }
    }

}
