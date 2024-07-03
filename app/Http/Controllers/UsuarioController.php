<?php

namespace App\Http\Controllers;

use App\Models\RolModel;
use App\Models\UsuarioModel;
use App\Models\TituloAcademicoModel; // Agregar el modelo de títulos académicos
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{

    public function storeUsuarios(Request $request)
    {
        try {
            // Validación de campos requeridos
            $modelo = new UsuarioModel();
            $campos_requeridos = $modelo->getFillable();
            $campos_recibidos = array_keys($request->all());
            $campos_faltantes = array_diff($campos_requeridos, $campos_recibidos);

            if (!empty($campos_faltantes)) {
                return response()->json([
                    "ok" => false,
                    "message" => "Los siguientes campos son obligatorios: " . implode(', ', $campos_faltantes)
                ], 400);
            }

            // Verificar si el usuario ya existe
            $busqueda = UsuarioModel::where("cedula", $request->cedula)->first();
            if ($busqueda) {
                if ($busqueda->estado == "A") {
                    return response()->json([
                        "ok" => false,
                        "message" => "El usuario " . $busqueda->nombres . " " . $busqueda->apellidos . " ya existe con el número de cédula " . $request->cedula
                    ], 400);
                }
                if ($busqueda->estado == "I") {
                    return response()->json([
                        "ok" => false,
                        "message" => "El usuario " . $busqueda->nombres . " " . $busqueda->apellidos . " ya existe con el número de cédula " . $request->cedula . " pero se encuentra inactivo"
                    ], 400);
                }
                if ($busqueda->estado == "E") {
                    return response()->json([
                        "ok" => false,
                        "message" => "Este usuario fue eliminado"
                    ], 400);
                }
            }

            // Limpiar nombres y apellidos para generar usuario
            $nombres = explode(" ", trim(strtolower($request->nombres)));
            $apellidos = explode(" ", trim(strtolower($request->apellidos)));

            if (count($nombres) == 2) {
                $usuario = ($nombres[0][0]);
                $nombres = ucfirst(trim($nombres[0])) . "  " . ucfirst(trim($nombres[1]));
            } else {
                return Response()->json([
                    "ok" => false,
                    "message" => "Error en limpiar los nombres. Verifique si está llenando correctamente los campos"
                ]);
            }

            if (count($apellidos) == 2) {
                $apellidos = ucfirst(trim($apellidos[0])) . "  " . ucfirst(trim($apellidos[1]));
                $usuario = $usuario . trim($apellidos[1]);
            } elseif (count($apellidos) == 3) {
                $usuario = $usuario . trim($apellidos[2]);
                $apellidos = ucfirst(trim($apellidos[0])) . "  " . ucfirst(trim($apellidos[2]));
            } else {
                return Response()->json([
                    "ok" => false,
                    "message" => "Error en limpiar los apellidos. Verifique si está llenando correctamente los campos"
                ]);
            }

            // Validar existencia del rol
            $modelo_rol = RolModel::find($request->id_rol);
            if (!$modelo_rol) {
                return Response()->json([
                    "ok" => true,
                    "message" => "El rol no existe con el id $request->id_rol"
                ], 400);
            }

            // Crear el usuario
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

            // Crear títulos académicos asociados al usuario
            if ($request->has('titulos_academicos')) {
                foreach ($request->titulos_academicos as $tituloData) {
                    $titulo = new TituloAcademicoModel();
                    $titulo->codigo = $tituloData['codigo'];
                    $titulo->descripcion = strtoupper($tituloData['descripcion']);
                    $titulo->nemonico = strtoupper($tituloData['nemonico']);
                    $titulo->ip_creacion = $request->ip();
                    $titulo->id_usuario = $modelo->id_usuario; // Relacionar título al usuario creado
                    $titulo->save();
                }
            }

            return Response()->json([
                "ok" => true,
                "message" => "Usuario creado con éxito"
            ], 200);
        } catch (Exception $e) {
            Log::error(__FILE__ . " > " . __FUNCTION__);
            Log::error("Mensaje : " . $e->getMessage());
            Log::error("Línea : " . $e->getLine());

            return Response()->json([
                "ok" => true,
                "message" => "Error interno en el servidor"
            ], 500);
        }
    }

    public function showUsuarios()
    {
        try{
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
