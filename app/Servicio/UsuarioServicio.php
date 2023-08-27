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
            }
            $this->obj_tipo_respuesta->setdata($datos[0]);
            
        }catch(Exception $e){
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Lo sentimos error en el servicio',false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
    
    public function createuser(){
        
    }

    public function editUser(){
        
    }

    public function deleteUser(){
        
    }

}