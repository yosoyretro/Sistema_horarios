<?php

namespace App\Http\Controllers;

use App\Models\RolModel;
use App\Services\MensajeAlertasServicio;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request as request_ip;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    private $servicio_informe;
    public function __construct()
    {
        $this->servicio_informe = new MensajeAlertasServicio();
    }
    public function storeRol(Request $request)
    {
        $this->servicio_informe->storeInformativoLogs(__FILE__,__FUNCTION__);
        try {

            $modelo = new RolModel();
            $campos_requeridos = $modelo->getFillable();
            $campos_recibidos = array_keys($request->all());
            $campos_faltantes = array_diff($campos_requeridos, $campos_recibidos);

            if (!empty(array_diff($campos_requeridos, $campos_recibidos))) {
                return response()->json([
                    "ok" => false,
                    "message" => "Los siguientes campos son obligatorios: " . implode(', ', $campos_faltantes)
                ], 400);
            }

            $modelo->descripcion = ucfirst(trim($request->descripcion));
            $modelo->ip_creacion = $request->ip();
            $modelo->ip_actualizacion = $request->ip();
            $modelo->id_usuario_creador = auth()->id() ?? 1;
            $modelo->id_usuario_actualizo = auth()->id() ?? 1;
            $modelo->estado = "A";
            $modelo->save();
            return Response()->json([
                "ok" => true,
                "message" => "Rol creado con exito"
            ], 200);
        } catch (Exception $e) {
            log::error(__FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());
            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function deleteRol(Request $request, $id)
    {
        
        try {
            $this->servicio_informe->storeInformativoLogs(__FILE__,__FUNCTION__);
            $asignatura = RolModel::find($id);
            if(!$asignatura){
                return Response()->json([
                    "ok" => true,
                    "message" => "El Rol no existe con el id $id"
                ], 400);    
            }
            
            RolModel::find($id)->updated([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id() ?? 1,
                "ip_actualizo" => $request->ip(),
            ]);

            return Response()->json([
                "ok" => true,
                "message" => "Rol eliminado con exito"
            ],200);
        } catch (Exception $e) {
            log::error(__FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());
            return Response()->json([
                "ok" => false,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }
    
    public function getRoles(Request $request)
    {
        try {
            log::info("Peticion entrante " . __FILE__ ." -> ". __FUNCTION__ . " ip " . request_ip::ip());
            $rol = RolModel::select("rol.id_rol","rol.descripcion","rol.estado","usuarios.usuario as usuarios_ultima_gestion","rol.fecha_actualizacion")
            ->whereIn("rol.estado", ["A", "I"])
            ->join('usuarios','rol.id_usuario_actualizo','usuarios.id_usuario')
            ->get();
        } catch (Exception $e) {
            log::error(__FILE__ . __FUNCTION__ . " MENSAJE => " . $e->getMessage());
            return Response()->json([
                "ok" => false,
                "message" => "Error interno en el servidor"
            ], 500);
        }finally{
            return Response()->json([
                "ok" => true,
                "mensaje" => "Datos obtenidos exitosamente"
            ], 200);
        }
    }
}
