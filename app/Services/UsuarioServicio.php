<?php

namespace App\Services;

use App\Services\RolServicio;
use App\Http\Responses\TypeResponse;
use App\Models\HistoricoModel;
use App\Models\UsuarioModel;
use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Log;


class UsuarioServicio
{

    protected $obj_usuario_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_usuario_modelo = new UsuarioModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }

    public function getdatausuario(array $data)
    {
        $datos = null;
        try {

            switch ($data["tipo_consulta"]) {
                case 1:
                    //consulta por cedula
                    $datos = UsuarioModel::where('cedula', $data["cedula"])->get();
                    break;
                case 2:
                    //consulta por nombres
                    $datos = UsuarioModel::where('nombres', 'LIKE', '%', $data["nombres"], '%')->get();
                    break;
                case 3:
                    //consulta por usuario
                    $datos = UsuarioModel::where('usuario', $data["usuario"])->get();
                    break;
            }

           // $datos->map(function ($titulos_academico) {
               // $array = [];
               // $servicio_titulo = new TituloAcademicoServicio();
               // $titulos_academico->id_titulo_academico = json_decode($titulos_academico->id_titulo_academico, true);
               // foreach ($titulos_academico->id_titulo_academico as $value) {
                 //   $response_titulo = $servicio_titulo->consultarTitulo(1, ['id_titulo_academico' => $value]);
                   // array_push($array, $response_titulo["data"]->first());
               // }
               // $titulos_academico->id_titulo_academico = $array;
               // return true;
            // });

           // $datos->map(function ($rol) {
              //  $servicio_rol = new RolServicio();
              //  $servicio_rol = $servicio_rol->Consultar(["tipo_consulta" => 1, "data" => $rol->id_rol]);
              //  $rol->id_rol =  $servicio_rol["data"]->first();

              //  return true;
            // });

            $this->obj_tipo_respuesta->setdata($datos);
        } catch (Exception $e) {
            log::alert($e->getMessage());
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Lo sentimos error en el servicio', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function createuser(array $user_data)
    {
        $response = new TypeResponse();
        try {
            $modelo = new UsuarioModel();
            $campos_requeridos = $modelo->getFillable();

            if ($campos_faltantes = array_diff($campos_requeridos, array_keys($user_data))) {
                throw new EXception("Estos campos son requeridos : " . implode(" , ", $campos_faltantes));
            }
            $clave = bcrypt($user_data["cedula"]);
            if (!is_numeric($user_data["cedula"])) throw new Exception("El campo de cedula tiene que ser numero");
            UsuarioModel::insert([
                "cedula" => $user_data["cedula"],
                "nombres" => strtoupper($user_data["nombres"]),
                "usuario" => $user_data["usuario"],
                "clave" => $clave,
                "imagen_perfil" => $user_data["imagen"] ?? null,
                "id_rol" => $user_data["id_rol"],
                "id_titulo_academico" => json_encode($user_data["id_titulo_academico"]) ?? [],
                "ip_creacion" => "192.168.14.13",
            ]);
            $response->setmensagge("Usuario grabado correctamente");
        } catch (Exception $e) {
            $mensaje = "";

            switch ($e->getCode()) {
                case 'HY000':
                    $mensaje = "Hace Falta un campo";
                    break;
                case '23000':
                    $mensaje = "En el registro ya existe un campo que se esta duplicando en otro registro , recuerde que los datos de los registros no se pueden repetir";
                    break;
                default:
                    $mensaje = $e->getMessage();
                    break;
            };
            $response->seterror($mensaje, $e->getCode());
            $response->setok(false);
        }

        return $response->getdata();
    }

    public function editUser($user_data)
    {
        $response = new TypeResponse();
        try {
            // se busca el usuario a editar utilizando el modelo UsuarioModel
            if (!UsuarioModel::where("id_usuario", $user_data['id_usuario'])->update(
                [
                    "imagen_perfil" => $user_data["imagen"],
                    "cedula" => $user_data['cedula'],
                    "nombres" => strtolower($user_data['nombres']),
                    "usuario" => $user_data['usuario'],
                    "id_rol" => $user_data['id_rol'],
                    "id_titulo_academico" => json_encode($user_data['id_titulo_academico']),
                    "estado" => $user_data['estado'],
                    "fecha_actualizacion" => now()
                ]
            )) throw new Exception('A ocurrido un error al actualizar el usuario');

            $this->obj_tipo_respuesta->setok(true);
        } catch (Exception $e) {
            $mensaje = "";
            log::alert("Error en la line => " . $e->getLine());
            log::alert("SOy el motivo" . $e->getMessage());
            switch ($e->getCode()) {
                case 'HY000':
                    $mensaje = "Hace Falta un campo";
                    break;
                case '23000':
                    $mensaje = "En el registro ya existe un campo que se esta duplicando en otro registro , recuerde que los datos de los registros no se pueden repetir";
                    break;
                default:
                    $mensaje = $e->getMessage();
                    break;
            };
            $response->seterror($mensaje, $e->getCode());
            $response->setok(false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

    public function deleteUser($userId)
    {
        try {

            $modelo = new UsuarioModel();
            $tabla = $modelo->getTable();

            $usuario = UsuarioModel::findOrFail($userId);
            HistoricoModel::insert(
                [
                    "tabla_proviene" => $tabla,
                    "datos" => json_encode($usuario),
                ]
            );
            $usuario->delete();
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setmensagge("Usuario eliminado con exito");
        } catch (Exception $e) {
            log::alert("Error " . $e->getMessage());
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al eliminar el usuario', false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

    public function createTokenById(int $id_usuario)
    {
        $response = new TypeResponse();
        try {
            $duracion_minutos = 60;
            $usuario = UsuarioModel::find($id_usuario);
            $token = $usuario->createToken('token_acceso', ['expires' => true, 'expires_at' => now()->addMinutes($duracion_minutos)])->plainTextToken;
            $response->setdata($token);
        } catch (Exception $e) {
            $response->setOk(false);
            $response->seterror($e->getMessage(), $e->getCode());
        }
        return $response->getdata();
    }
}
