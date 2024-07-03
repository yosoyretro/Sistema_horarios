<?php

namespace App\Services;

use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Log;
use Exception;

class UsuarioServicio
{
    public function crearUsuario($data)
    {
        try {
            $usuario = new UsuarioModel();
            $usuario->cedula = $data['cedula'];
            $usuario->nombres = $data['nombres'];
            $usuario->apellidos = $data['apellidos'];
            $usuario->usuario = $data['usuario'];
            $usuario->clave = bcrypt($data['cedula']);
            $usuario->id_rol = $data['id_rol'];
            $usuario->ip_creacion = $data['ip'];
            $usuario->ip_actualizacion = $data['ip'];
            $usuario->id_usuario_creador = $data['id_usuario_creador'] ?? 1;
            $usuario->id_usuario_actualizo = $data['id_usuario_actualizo'] ?? 1;
            $usuario->imagen_perfil = $data['imagen_perfil'] ?? null;
            $usuario->estado = "A";
            $usuario->save();

            return [
                "ok" => true,
                "message" => "Usuario creado con éxito",
                "data" => $usuario
            ];
        } catch (Exception $e) {
            Log::error("Mensaje : " . $e->getMessage());
            Log::error("Linea : " . $e->getLine());
            return [
                "ok" => false,
                "message" => "Error interno en el servidor",
                "error" => $e->getMessage()
            ];
        }
    }

    public function obtenerUsuarios()
    {
        try {
            $usuarios = UsuarioModel::select("id_usuario", "cedula", "nombres", "apellidos", "usuario", "imagen_perfil", "rol.id_rol", "rol.descripcion")
                ->join("rol", "usuarios.id_rol", "=", "rol.id_rol")
                ->get();

            return [
                "ok" => true,
                "data" => $usuarios
            ];
        } catch (Exception $e) {
            Log::error("Mensaje : " . $e->getMessage());
            Log::error("Linea : " . $e->getLine());
            return [
                "ok" => false,
                "message" => "Error interno en el servidor",
                "error" => $e->getMessage()
            ];
        }
    }
    public function actualizarUsuario($id, $data)
    {
        try {
            $usuario = UsuarioModel::find($id);
            if (!$usuario) {
                return [
                    "ok" => false,
                    "message" => "El usuario con id $id no existe"
                ];
            }
            $usuario->cedula = $data['cedula'] ?? $usuario->cedula;
            $usuario->nombres = $data['nombres'] ?? $usuario->nombres;
            $usuario->apellidos = $data['apellidos'] ?? $usuario->apellidos;
            $usuario->usuario = $data['usuario'] ?? $usuario->usuario;
            $usuario->id_rol = $data['id_rol'] ?? $usuario->id_rol;
            $usuario->imagen_perfil = $data['imagen_perfil'] ?? $usuario->imagen_perfil;
            $usuario->save();
            return [
                "ok" => true,
                "message" => "Usuario actualizado con éxito",
                "data" => $usuario
            ];
        } catch (Exception $e) {
            Log::error("Mensaje : " . $e->getMessage());
            Log::error("Linea : " . $e->getLine());
            return [
                "ok" => false,
                "message" => "Error interno en el servidor",
                "error" => $e->getMessage()
            ];
        }
    }

    public function eliminarUsuario($id, $ip)
    {
        try {
            $usuario = UsuarioModel::find($id);
            if (!$usuario) {
                return [
                    "ok" => false,
                    "message" => "El usuario con id $id no existe"
                ];
            }
            $usuario->update([
                "estado" => "E",
                "id_usuario_actualizo" => auth()->id(),
                "ip_actualizo" => $ip,
            ]);

            return [
                "ok" => true,
                "message" => "Usuario eliminado con éxito"
            ];
        } catch (Exception $e) {
            Log::error("Mensaje : " . $e->getMessage());
            Log::error("Linea : " . $e->getLine());
            return [
                "ok" => false,
                "message" => "Error interno en el servidor",
                "error" => $e->getMessage()
            ];
        }
    }
}
