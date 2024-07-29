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

    private $servicio_informe;

    public function storeHorario(Request $request)
    {
        $response = new TypeResponse();
        try {
            DB::beginTransaction();
            $detalles = $request->input("detalles");
            $idUsuario = $request->input("id_usuario");
            $idPeriodoElectivo = $request->input("id_periodo_electivo");
            $idEducacionGlobal = $request->input("id_educacion_global");
            $insert_data = collect($detalles)->map(function ($values) use ($request, $idUsuario, $idPeriodoElectivo, $idEducacionGlobal){
                $values = (object)$values;
                $consulta = ModelsDistribucionHorario::where("id_usuario", $idUsuario)
                ->where("id_periodo_academico", $idPeriodoElectivo)
                ->where("id_educacion_global", $idEducacionGlobal)
                ->where("id_materia", $values->id_materia)
                ->where("id_nivel", $values->id_curso)
                ->where("id_paralelo", $values->id_paralelo)
                ->where("dia", $values->dia)
                ->where("hora_inicio", ">=", Carbon::parse($values->hora_inicio))
                ->where("hora_termina", "<=", Carbon::parse($values->hora_termina))
                ->get();

                if ($consulta->count() > 0) {
                throw new Exception("Ocurrió un error al crear este horario, ya existe una hora en el rango de " . $values->hora_inicio . " y " . $values->hora_termina);
                }

                return [
                    "id_usuario" => $idUsuario,
                    "id_periodo_academico" => $idPeriodoElectivo,
                    "id_educacion_global" => $idEducacionGlobal,
                    "id_materia" => $values->id_materia,
                    "id_nivel" => $values->id_curso,
                    "id_paralelo" => $values->id_paralelo,
                    "dia" => $values->dia,
                    "hora_inicio" => Carbon::parse($values->hora_inicio),
                    "hora_termina" => Carbon::parse($values->hora_termina),
                    "fecha_creacion" => now(),
                    "fecha_actualizacion" => now(),
                    "estado" => 'activo'
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

            // Obtención de parámetros de búsqueda
            $idUsuario = $request->input("id_usuario");
            $idPeriodoElectivo = $request->input("id_periodo_electivo");
            $idEducacionGlobal = $request->input("id_educacion_global");
            $idMateria = $request->input("id_materia");
            $idNivel = $request->input("id_nivel");
            $idParalelo = $request->input("id_paralelo");

            // Construcción de la consulta
            $query = ModelsDistribucionHorario::query();

            if ($idUsuario) {
                $query->where("id_usuario", $idUsuario);
            }

            if ($idPeriodoElectivo) {
                $query->where("id_periodo_academico", $idPeriodoElectivo);
            }

            if ($idEducacionGlobal) {
                $query->where("id_educacion_global", $idEducacionGlobal);
            }

            if ($idMateria) {
                $query->where("id_materia", $idMateria);
            }

            if ($idNivel) {
                $query->where("id_nivel", $idNivel);
            }

            if ($idParalelo) {
                $query->where("id_paralelo", $idParalelo);
            }

            // Obtención de los resultados
            $distribuciones = $query->get();

            // Respuesta JSON con los datos obtenidos
            return response()->json([
                "ok" => true,
                "data" => $distribuciones
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
