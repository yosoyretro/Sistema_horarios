<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Log;
use Exception;

class UsuarioServicio
{

    public function CreateUsuario(array $usuarioData)
    {
        $response = new TypeResponse();
        try {
            if (!UsuarioModel::insert([
                "cedula" => $usuarioData["cedula"],
                "nombres" => strtoupper($usuarioData["nombres"]),
                "apellidos" => strtoupper($usuarioData["apellidos"]),
                "id_rol" => $usuarioData["id_rol"],
                "ip_creacion" => "192.168.14.13"
            ])) throw new Exception("Ha ocurrido un error al crear el usuario " . strtoupper($usuarioData["nombres"]));

            $response->setmensagge("Usuario creado con éxito");
        } catch (Exception $e) {
            $mensaje = "";
            switch ($e->getCode()) {
                case 'HY000':
                    $mensaje = "Hace falta un campo";
                    break;
                case '23000':
                    $mensaje = "Ya existe un registro con los mismos datos. Recuerde que los datos no se pueden repetir en ningún registro";
                    break;
                default:
                    $mensaje = "Ha ocurrido un error al crear el usuario";
                    break;
            };
            $response->setok(false);
            $response->seterror($mensaje, $e->getCode());
        }
        return $response->getdata();
    }

    public function UpdateUsuario(array $usuarioData)
    {
        $response = new TypeResponse();
        try {
            Log::alert("Pasó por la función de actualizar el usuario");
            $usuario = UsuarioModel::where("id_usuario", $usuarioData["id_usuario"])->update([
                "cedula" => $usuarioData["cedula"],
                "nombres" => strtoupper($usuarioData["nombres"]),
                "apellidos" => strtoupper($usuarioData["apellidos"]),
                "id_rol" => $usuarioData["id_rol"],
                "fecha_actualizacion" => now()->format('Y-m-d'),
                "hora_actualizacion" => now()->format('H:i:s'),
            ]);
            $response->setdata($usuario);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
            Log::alert("ERROR : " . $e->getMessage());
        }
        return $response->getdata();
    }

    public function ConsultarUsuario($opcion, $data = null)
    {
        $datos = null;

        try {
            $response = new TypeResponse();
            switch ($opcion) {
                case 1:
                    // Consulta por ID de usuario
                    $datos = UsuarioModel::where('id_usuario', $data["id_usuario"])->where("estado", "A")->get();
                    break;
                case 2:
                    // Consulta por cédula
                    $datos = UsuarioModel::where('cedula', $data["cedula"])->where("estado", "A")->get();
                    break;
                case 3:
                    // Consulta por nombres
                    $datos = UsuarioModel::where('nombres', 'LIKE', '%' . $data["nombres"] . '%')->where("estado", "A")->get();
                    break;
                case 4:
                    // Consulta por apellidos
                    $datos = UsuarioModel::where('apellidos', 'LIKE', '%' . $data["apellidos"] . '%')->where("estado", "A")->get();
                    break;
                case 5:
                    // Consulta por rol
                    $datos = UsuarioModel::where('id_rol', $data["id_rol"])->where("estado", "A")->get();
                    break;
                case 6:
                    // Consulta por estado
                    $datos = UsuarioModel::where("estado", "A")->get();
                    break;
                case 7:
                    // Consulta por todos los datos
                    $datos = UsuarioModel::whereIn('estado', ['A', 'I'])->get();
                    break;
            }
            $response->setdata($datos);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror("Ha ocurrido un error en la consulta del usuario", $e->getMessage());
        }
        return $response->getdata();
    }

    public function DeleteUsuario($id_usuario)
    {
        try {
            $response = new TypeResponse();
            $usuario = UsuarioModel::where("id_usuario", $id_usuario)->update([
                "cedula" => "E" . random_int(1, 500) . " - " . now(),
                "nombres" => "E" . random_int(1, 500) . " - " . now(),
                "apellidos" => "E" . random_int(1, 500) . " - " . now(),
                "estado" => "E",
                "fecha_actualizacion" => now()->format('Y-m-d'),
                "hora_actualizacion" => now()->format('H:i:s'),
            ]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
            Log::alert("ERROR : " . $e->getMessage());
        }
        return $response->getdata();
    }
}
