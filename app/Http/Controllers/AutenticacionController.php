<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use App\Services\UsuarioServicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AutenticacionController extends Controller
{

    public function autenticacion(Request $request)
    {
        try {
            $usuario = UsuarioModel::select(
                "cedula",
                "nombres",
                "apellidos",
                "usuario",
                "imagen_perfil",
                "rol.id_rol",
                "rol.descripcion"
            )
                ->leftjoin("rol", "usuarios.id_rol", "=", "rol.id_rol")
                ->where("usuario", $request->usuario)
                ->first();
            if (!$usuario) {
                return response()->json([
                    "ok" => false,
                    "message" => "El usuario no existe en nuestra base de datos"
                ], 400);
            }
            if ($usuario->estado == "E") {
                return response()->json([
                    "ok" => false,
                    "message" => "El usuario esta eliminado"
                ], 400);
            }

            if ($usuario->estado == "I") {
                return response()->json([
                    "ok" => false,
                    "message" => "El usuario esta inactivo"
                ], 400);
            }
            if (!password_verify($request->clave, $usuario->clave)) {
                return response()->json([
                    "ok" => false,
                    "message" => "verifique que sus credenciales esten correctas"
                ], 401);
            }

            $usuario_token = new UsuarioModel();
            $token_all = $usuario_token->createToken($usuario->cedula);
            $accessToken = $token_all->accessToken;
            
            return Response()->json([
                "ok" => true,
                "data" => $usuario,
                "token" => $accessToken,
                "mensaje" => "El tiempo del token expira en 1hora"
            ], 200);
        } catch (Exception $e) {
            return Response()->json([
                "ok" => false,
                "mensaje" => $e->getMessage(),
                "Linea" => $e->getLine()
            ], 500);
        }
    }
}
