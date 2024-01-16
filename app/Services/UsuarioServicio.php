<?php

namespace App\Services;
use App\Services\RolServicio;
use App\Http\Responses\TypeResponse;
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

    public function getdatausuario($data)
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
                case 4:
                    //consulta por el estado 
                    $datos = UsuarioModel::where('estado', 'A')->get();
                    break;
                case 5:
                    //consulta por el id del titulo academico;
                    $datos = UsuarioModel::join("titulo_academico","usuario.id_usuario","titulo_academico.id_titulo_academico")->where("titulo_academico.id_titulo_academico",$data["id_titulo_academico"])->get();
                    log::alert("SOY EL DATO");
                    log::alert(collect($datos));
                    break;

            }
            
            $titulo_descripcion = $datos->map(function ($titulos_academico) {
                $array = [];
                $servicio_titulo = new TituloAcademicoServicio();
                $titulos_academico->id_titulo_academico = json_decode($titulos_academico->id_titulo_academico,true);
                foreach($titulos_academico->id_titulo_academico as $value){
                    $response_titulo = $servicio_titulo->consultarTitulo(1,['id_titulo_academico'=>$value]);
                    array_push($array,$response_titulo["data"]->first());
                }
                $titulos_academico->id_titulo_academico = $array;
                return true;
            });

            $rol = $datos->map(function ($rol) {
                $servicio_rol = new RolServicio();
                $servicio_rol = $servicio_rol->Consultar(["tipo_consulta"=>1,"data"=>$rol->id_rol]);
                $rol->id_rol =  $servicio_rol["data"]->first();

                return true;
            });

            $this->obj_tipo_respuesta->setdata($datos);
        } catch (Exception $e) {
            log::alert($e->getMessage());
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Lo sentimos error en el servicio', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function createuser(array $userData)
    {
        $response = new TypeResponse();
        try {
            $clave = bcrypt($userData["cedula"]);
            UsuarioModel::insert([
                "cedula"=>$userData["cedula"],
                "nombres" => $userData["nombres"],
                "usuario"=>$userData["usuario"],
                "clave"=>$clave,
                "imagen_perfil" => $userData["imagen"]??null,
                "id_rol"=>$userData["id_rol"],
                "id_titulo_academico"=>json_encode($userData["id_titulo_academico"])??[],
                "ip_creacion"=>"192.168.14.13",
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
            $response->seterror($mensaje,$e->getCode());
            $response->setok(false);
        }

        return $response->getdata();
    }

    public function editUser($userData)
    {
        $response = new TypeResponse();
        try {
            // se busca el usuario a editar utilizando el modelo UsuarioModel
            if (!UsuarioModel::where("id_usuario",$userData['id_usuario'])->update(  
                [
                    "imagen_perfil" => $userData["imagen"]??null,
                    "cedula"=>$userData['cedula'],
                    "nombres"=>strtoupper($userData['nombres']),
                    "usuario"=>$userData['usuario'],
                    "id_rol"=>$userData['id_rol'],
                    "id_titulo_academico"=>json_encode($userData['id_titulo_academico']),
                    "updated_at"=>now()
                ]
            ))throw new Exception('A ocurrido un error al actualizar el usuario');

            $this->obj_tipo_respuesta->setok(true);
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
            $response->seterror($mensaje,$e->getCode());
            $response->setok(false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

    public function deleteUser($userId)
    {
        try {
            //se busca el usuario a eliminar
            $usuario = UsuarioModel::findOrFail($userId);

            //pasamos el estado activo a inactivo
            $usuario->estado = 'I';
            $usuario->id_titulo_academico = json_encode([]);
            $usuario->save();
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setmensagge("Usuario eliminado con exito");
            $this->obj_tipo_respuesta->setdata(null); // No hay datos para devolver después de eliminar
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al eliminar el usuario', false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }
}
