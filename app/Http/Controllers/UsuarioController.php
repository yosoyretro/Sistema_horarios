<?php

namespace App\Http\Controllers;

use App\Models\RolModel;
use App\Models\UsuarioModel;
use App\Services\MensajeAlertasServicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    private $servicio_informe;

    public function __construct()
    {
        $this->servicio_informe = new MensajeAlertasServicio();
    }
    public function storeUsuarios(Request $request)
    {
        try {
            $this->servicio_informe->storeInformativoLogs(__FILE__,__FUNCTION__);
            $modelo = new UsuarioModel();
            
            $campos_requeridos = $modelo->getFillable();
            $campos_recibidos = array_keys($request->all());
            $campos_faltantes = array_diff($campos_requeridos, $campos_recibidos);
            if (!empty(array_diff($campos_requeridos, $campos_recibidos))) {
                return response()->json([
                    "ok" => false,
                    "message" => "Los siguientes campos son obligatorios: " . implode(', ', $campos_faltantes)
                ], 400);
            }
            $usuario = "";
            $busqueda = UsuarioModel::where("cedula",$request->cedula)->first();
            if($busqueda){
                if($busqueda->estado == "A"){
                    return response()->json([
                        "ok" => false,
                        "message" => "El usuario " . $busqueda->nombres . " "  . $busqueda->apellidos . " ya existe con el numero de cedula de " . $request->cedula 
                    ], 400);
                }
                if($busqueda->estado == "I"){
                    return response()->json([
                        "ok" => false,
                        "message" => "El usuario " . $busqueda->nombres . " "  . $busqueda->apellidos . " ya existe con el numero de cedula de " . $request->cedula  . " pero se encuetra inactivo"
                    ], 400);
                }
                if($busqueda->estado == "E"){
                    return response()->json([
                        "ok" => false,
                        "message" => "Este usuario fue eliminado"
                    ], 400);
                }
            }

            $nombres = explode(" ",trim(strtolower($request->nombres)));
            $apellidos = explode(" ",trim(strtolower($request->apellidos)));
            
            if(count($nombres) == 2){
                $usuario = ($nombres[0][0]);
                $nombres = ucfirst(trim($nombres[0])) . "  " . ucfirst(trim($nombres[1]));
            }else{
                return Response()->json([
                    "ok" => false,
                    "message" => "Error en limpiar los nombres verifique bien si esta llenando bien los campos"
                ]);
            }

            if(count($apellidos) == 2){
                $apellidos = ucfirst(trim($apellidos[0])) . "  " . ucfirst(trim($apellidos[1]));
                $usuario = $usuario . trim($apellidos[1]);
            }elseif(count($apellidos) == 3){
                $usuario = $usuario . trim($apellidos[2]);
                $apellidos = ucfirst(trim($apellidos[0])) . "  " . ucfirst(trim($apellidos[2]));
            }else{
                return Response()->json([
                    "ok" => false,
                    "message" => "Error en limpiar los apellidos verifique bien si esta llenando bien los campos"
                ]);
            }
            $modelo_rol = RolModel::find($request->id_rol);
            if(!$modelo_rol){
                return Response()->json([
                    "ok" => true,
                    "message" => "El rol no existe con el id  $request->id_rol"
                ], 400);
            }
            $modelo->cedula = $request->cedula;
            $modelo->nombres = $nombres;
            $modelo->apellidos = $apellidos;
            $modelo->usuario = $usuario;
            $modelo->clave = bcrypt($request->cedula);
            $modelo->id_rol = $request->id_rol;
            $modelo->ip_creacion = $request->ip();
            $modelo->ip_actualizacion = $request->ip();
            $modelo->id_usuario_creador = auth()->id() ?? 1;
            $modelo->id_usuario_actualizo = auth()->id() ?? 1;
            $modelo->imagen_perfil = null;
            $modelo->estado = "A";
            $modelo->save();

            return Response()->json([
                "ok" => true,
                "message" => "Usuario creado con exito"
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

    public function showUsuarios()
    {
        try{
            $this->servicio_informe->storeInformativoLogs(__FILE__,__FUNCTION__);$this->servicio_informe->storeInformativoLogs(__FILE__,__FUNCTION__);
            $usuarios = UsuarioModel::select("id_usuario","cedula","nombres"
            ,"apellidos","usuario",
            "imagen_perfil","rol.id_rol",
            "rol.descripcion")
            ->join("rol","usuarios.id_rol","=","rol.id_rol")
            ->get();
            return Response()->json([
                "ok" => true,
                "data" => $usuarios
            ], 200);
        }catch (Exception $e) {
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }   
    }

    public function deleteUsuario(Request $request,$id)
    {
        try{
            $this->servicio_informe->storeInformativoLogs(__FILE__,__FUNCTION__);
            $usuario = UsuarioModel::find($id);
            if(!$usuario){
                return Response()->json([
                    "ok" => true,
                    "message" => "El usuario con id  $request->id_rol no existe"
                ], 400);
            }
            $usuario->updated([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id(),
                "ip_actualizo" => $request->ip(),
            ]);

            return Response()->json([
                "ok" => true,
                "data" => "Usuario eliminado con exito"
            ], 200);
        }catch (Exception $e) {
            log::error( __FILE__ . " > " . __FUNCTION__);
            log::error("Mensaje : " . $e->getMessage());
            log::error("Linea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }   
    }
}
