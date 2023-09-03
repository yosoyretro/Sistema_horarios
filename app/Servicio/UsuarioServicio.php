<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\UsuarioModel;
use Exception;

use Illuminate\Support\Facades\Log;


class UsuarioServicio{
    protected $obj_usuario_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_usuario_modelo = new UsuarioModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }

    public function getdatausuario($data){
        $datos = null;
        try{
            switch($data["tipo_consulta"]){
                case 1:
                    //consulta por cedula
                    $datos = UsuarioModel::where('cedula',$data["data"])->get();
                case 2:
                    //consulta por nombres
                    $datos = UsuarioModel::where('nombres','LIKE','%',$data["data"],'%')->get();
    
                case 3:
                    //consulta por usuario
                    $datos = UsuarioModel::where('usuario',$data["data"])->get();
                case 4:
                    //consulta por toddo los usuarios activo
                    $datos = UsuarioModel::Where('estado','A')->get();
            }
            $this->obj_tipo_respuesta->setdata($datos[0]);
            
        }catch(Exception $e){
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Lo sentimos error en el servicio',false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
    
    public function createuser($userData){
        try {
            //Crear nuevo usuario
            $nuevoUsuario = new UsuarioModel();
            $nuevoUsuario->cedula = $userData['cedula'];
            $nuevoUsuario->nombres = $userData['nombres'];
            $nuevoUsuario->usuario = $userData['usuario'];
            $nuevoUsuario->clave = $userData['clave'];
            $nuevoUsuario->id_rol = $userData['id_rol']; // asignar el ID del rol
            $nuevoUsuario->id_titulo_academico = $userData['id_titulo_academico']; // asignar el id del título académico

            $nuevoUsuario->save();

            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($nuevoUsuario);
        } catch (Exception $e){
                    // configurar la respuesta de error en el objeto TypeResponse
        $this->obj_tipo_respuesta->setok(false);
        $this->obj_tipo_respuesta->seterror('Error al crear el usuario', false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

    public function editUser($userData){
        try {
            // se busca el usuario a editar utilizando el modelo UsuarioModel
            $usuario = UsuarioModel::findOrFail($userData['id_usuario']);            
            $usuario->cedula = $userData['cedula'];
            $usuario->nombres = $userData['nombres'];
            $usuario->usuario = $userData['usuario'];
            $usuario->clave = $userData['clave'];
            $usuario->id_rol = $userData['id_rol'];
            $usuario->id_titulo_academico = $userData['id_titulo_academico'];

            $usuario->save();

            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($usuario);
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al editar el usuario', false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

    public function deleteUser($userId){
        try {
            //se busca el usuario a eliminar
            $usuario = UsuarioModel::findOrFail($userId);

            //pasamos el estado activo a inactivo
            $usuario->estado = 'I';
            $usuario->save();

            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata(null);// No hay datos para devolver después de eliminar
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al eliminar el usuario', false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

}